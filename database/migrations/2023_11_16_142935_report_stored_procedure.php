<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
DB::unprepared("DROP PROCEDURE IF EXISTS `report`;
CREATE PROCEDURE `report` (IN `starting_date` DATE, IN `ending_date` DATE)
BEGIN
    DECLARE iterating_date date;
    DECLARE iterating_month int;
    DECLARE iterating_year int ;
    DECLARE paid int;
    DROP TABLE IF EXISTS `report`;
    CREATE TABLE report (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `month` int not null,
    `year` int not null,
    `paid` double DEFAULT 0,
    `outstanding` double DEFAULT 0,
    `overdue` double DEFAULT 0);
    SET iterating_date = starting_date;
    WHILE(iterating_date <= ending_date)
        DO
        SET iterating_month = month(iterating_date);
        SET iterating_year = year(iterating_date);
        INSERT INTO `report` (`month`,`year`,`paid`) VALUES (MONTH(iterating_date),Year(iterating_date),paid);
        UPDATE `report` SET `paid` =  (SELECT COALESCE(sum(amount),0) from payments where MONTH(paid_on) = iterating_month AND YEAR(paid_on) = iterating_year GROUP by paid_on) order by id desc
        limit 1;
        UPDATE `report` SET `outstanding` = (SELECT COALESCE(SUM(remaining_amount),0) from (SELECT transactions.total_amount, (transactions.total_amount - COALESCE(sum(payments.amount), 0)) as remaining_amount FROM `transactions` left JOIN payments on transactions.id = payments.transaction_id AND  MONTH(payments.paid_on) <= iterating_month AND YEAR(payments.paid_on) <= iterating_year  WHERE
        MONTH(transactions.due_on) >= iterating_month AND YEAR(transactions.due_on) >= iterating_year  GROUP BY transactions.id HAVING transactions.total_amount - COALESCE(sum(payments.amount), 0) > 0)q) order by id desc limit 1;
        UPDATE `report` SET `overdue` = (SELECT COALESCE(SUM(remaining_amount),0) from (SELECT transactions.total_amount, (transactions.total_amount - COALESCE(sum(payments.amount), 0)) as remaining_amount FROM `transactions` left JOIN payments on transactions.id = payments.transaction_id AND  MONTH(payments.paid_on) <= iterating_month AND YEAR(payments.paid_on) <= iterating_year WHERE
        MONTH(transactions.due_on) < iterating_month AND YEAR(transactions.due_on) <= iterating_year  GROUP BY transactions.id HAVING transactions.total_amount - COALESCE(sum(payments.amount), 0) > 0)q)order by id desc limit 1;
        set iterating_date = date_add(iterating_date,INTERVAL 1 MONTH);
    end WHILE;
    select * from report;
    Drop Table report;
END");
}
/**
* Reverse the migrations.
*/
public function down(): void
{
//
}
};