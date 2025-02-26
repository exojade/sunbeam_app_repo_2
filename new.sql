SELECT SUM(allocated_payment)
FROM(    
    SELECT 
    ef.fee_id,
    ef.fee,
    ef.type,
    ef.amount AS original_fee_amount,
    -- Cumulative allocation for all payments up to the current payment
    ROUND((ef.amount / total.total_fee) * cumulative.total_paid_up_to_date, 2) AS cumulative_allocation, 
    -- Allocation of the specific payment
    ROUND((ef.amount / total.total_fee) * current_payment.current_payment, 2) AS allocated_payment,       
    -- Remaining balance after cumulative payments
    ROUND(ef.amount - ((ef.amount / total.total_fee) * cumulative.total_paid_up_to_date), 2) AS remaining_balance 
FROM 
    enrollment_fees ef
JOIN 
    (SELECT 
        enrollment_id,
        SUM(amount_paid) AS total_paid_up_to_date
     FROM 
        payment
     WHERE 
        enrollment_id = (SELECT enrollment_id FROM payment WHERE payment_id = 121)
        AND date_paid <= (SELECT date_paid FROM payment WHERE payment_id = 121)
    ) AS cumulative ON ef.enrollment_id = cumulative.enrollment_id
JOIN 
    (SELECT 
        enrollment_id,
        amount_paid AS current_payment
     FROM 
        payment
     WHERE 
        payment_id = 121
    ) AS current_payment ON ef.enrollment_id = current_payment.enrollment_id
JOIN 
    (SELECT 
        enrollment_id,
        SUM(amount) AS total_fee
     FROM 
        enrollment_fees
     WHERE 
        enrollment_id = (SELECT enrollment_id FROM payment WHERE payment_id = 121)
     GROUP BY 
        enrollment_id
    ) AS total ON ef.enrollment_id = total.enrollment_id
    
    ) AS table2