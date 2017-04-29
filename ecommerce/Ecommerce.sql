1.####
SELECT product_id  FROM categories 
WHERE category_id = 'M-1' 
LIMIT 5

2.Highst sells(5)
SELECT product_id,(quantity*each_price) AS amount
FROM sells_order_details
GROUP BY product_id
ORDER BY amount DESC
LIMIT 5

3. Today sells
SELECT sd.product_id
FROM sells_order_details sd INNER JOIN sells_order s ON(sd.sell_id = s.sell_id)
WHERE s.created_at = DATE('2016-05-21')

**** Number of sell of an product
SELECT  count(*)
FROM sells_order_details 
WHERE product_id = 'M-1'

**** In a particuler date Number of sell of an product
SELECT  count(*)
FROM sells_order_details sd INNER JOIN sells_order s ON(sd.sell_id = s.sell_id)
WHERE sd.product_id = 'M-1'
AND s.created_at = DATE('2016-06-02')

4. Last 6 month sells(which)
SELECT sd.product_id
FROM sells_order_details sd INNER JOIN sells_order s ON(sd.sell_id = s.sell_id)
WHERE s.created_at between DATE('2016-05-21') AND DATE('2016-06-02')

****** Total sells between two dates
SELECT SUM(quantity*each_price) AS Total
FROM sells_order_details sd INNER JOIN sells_order s ON(sd.sell_id = s.sell_id)
WHERE s.created_at between DATE('2016-05-21') AND DATE('2016-06-02')



##### INSERT 
INSERT INTO cart(cart_id, session_id, user_id)
VALUES('CAAA-9', 'SSS-9', 2345)

#####
INSERT INTO cart_details(product_id, quantity, cart_id)
VALUES('M-2', 15, 'CAAA-9')

####UPDATE
UPDATE  cart_details
SET quantity = 35
WHERE product_id = 'M-2' AND cart_id = 'CAAA-1'

###SHOW
SELECT * FROM cart_details

 ###
 SELECT product_id, quantity 
 FROM cart_details
 WHERE cart_id = 'CAAA-4'
 
 ###
 IF EXISTS(SELECT product_id, quantity 
 FROM cart_details
 WHERE cart_id = 'CAAA-4' )
 UPDATE  cart_details
 SET quantity = quantity + 5
 WHERE product_id = 'M-2' AND cart_id = 'CAAA-4'
 ELSE
 INSERT INTO cart_details(product_id, quantity, cart_id)
 VALUES('M-2', 15, 'CAAA-4')
 