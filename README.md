steps to run the app
--------------------
1- clone the repo
2- run composer update
3- create a database and update .env database cnfigurations
4- run php artisan migrate --seed (admin user will be created with email: admin@gmail.com and password: password)

Database structure
-------------------
1- users table 
	name
	email
	password
	role (Admin | Customer)

2- transactions table
	user_id (payer)
	amount
	total_amount (amount + vat if vat not included)
	due_on
	vat
	is_vat_inclusive
	status

3- payments
	transaction_id
	amount
	paid_on
	details

4- report stored procedure (calculate paid, outstanding, overdue for each month within given range)

APIs endpoint
-------------
1- route:api/register 
   method:post
   parameters: name, email, password
   usage: register new customer

2- route:api/login
   method:post
   parameters:email, password
   usage: customer/admin login and new token will be created to him

3- route:api/logout
   method:post
   Authorization bearer token: use the token that was created by login endpoint
   usage: user will be logout

4- route:api/transaction/create (Accessed by Admin only)
   method:post
   Authorization bearer token: use the token that was created by login endpoint
   parameters: amount, vat, is_vat_inclusive, due_on(date), payer(customer email)
   usage: create a transaction for customer


 5- route:api/payment/create (Accessed by Admin only)
    method:post
    Authorization bearer token: use the token that was created by login endpoint
    parameters: transaction_id, amount, paid_on(date), details
    usage: create payment to the transaction

 6- route:api/transaction
 	method:get
 	Authorization bearer token: use the token that was created by login endpoint
 	usage: 
 		Admin can view all customers’ transactions
		Customer can view only his transactions

 7- route:api/report  (Accessed by Admin only)
 	method:post
 	Authorization bearer token: use the token that was created by login endpoint
 	parameters: starting_date, ending_date
 	usage: generate monthly reports to review financial performance over a period.

 Design pattern
 --------------
 service pattern

 	1- UserService class (create user function)
 	2- TransactionService class (create transaction & retrieve transactions depending on logged in user role)
 	3- PaymentService class (create payment function)
 	4- ReportService (generate report within given range)

Middelware
-----------
Admin middleware 

cronjob
-------
updateTransactionsStatus command was created and used in scheduler to run daily to update transactions status



