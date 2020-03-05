CREATE TABLE IF NOT EXISTS `Order_table` (
                            `id` int auto_increment not null,
                            `Product_code` int(10)  not null,
                            `Poroduct_name` varchar(60) not null,
                            `Customers_name` varchar(60) not null,
                            `PhoneNumber` varchar(10) not null'
                            `amount` int(4) not null,
                            `date_created` timestamp not null default current_t$
                            `date_modified` timestamp not null default current_$
                            PRIMARY KEY (`id`)
                            ) CHARACTER SET utf8 COLLATE utf8_general_ci
