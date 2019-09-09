<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'quantity' => 1
    ];
});

// DROP VIEW IF EXISTS product_variation_stock_view;
// DROP VIEW IF EXISTS stocks_view;
// DROP VIEW IF EXISTS product_variation_order_view;

// CREATE VIEW stocks_view AS
// 		SELECT
// 			stocks.product_variation_id as id,
//             SUM(stocks.quantity) as quantity
//         FROM stocks
//         GROUP BY stocks.product_variation_id;
// CREATE VIEW product_variation_order_view AS 
// 		SELECT
//         	product_variation_order.product_variation_id as id,
//             SUM(product_variation_order.quantity) as quantity
//         FROM product_variation_order
//         Group BY product_variation_order.product_variation_id;
        
// CREATE VIEW product_variation_stock_view AS
// 	SELECT
// 		product_variations.product_id AS product_id,
//         product_variations.id as product_variation_id,
//         COALESCE(SUM(stocks.quantity) - SUM(product_variation_order.quantity), 0) as stock
//     FROM product_variations
//     LEFT JOIN stocks_view
// 		AS stocks USING (id)
//     LEFT JOIN product_variation_order_view
//     	AS product_variation_order USING(id)
//         GROUP BY product_variations.id