-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2017 at 06:57 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackathon_pmay`
--

-- --------------------------------------------------------

--
-- Table structure for table `tp_adm_ltvslabs`
--

CREATE TABLE IF NOT EXISTS `tp_adm_ltvslabs` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `slab_type` tinyint(4) NOT NULL,
  `slab_desc` varchar(50) NOT NULL,
  `amount_from` double NOT NULL,
  `amount_to` double NOT NULL,
  `percentage` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tp_adm_ltvslabs`
--

INSERT INTO `tp_adm_ltvslabs` (`id`, `slab_type`, `slab_desc`, `amount_from`, `amount_to`, `percentage`, `created_at`) VALUES
(1, 1, 'Own Contribution', 0, 20408, 98, '2017-01-18 05:44:26'),
(2, 1, 'Own Contribution', 20408, 333333, 90, '2017-01-18 05:44:28'),
(3, 1, 'Own Contribution', 333333, 1875000, 80, '2017-01-18 05:44:30'),
(4, 1, 'Own Contribution', 1875000, 300000000, 75, '2017-01-25 00:49:55'),
(5, 2, 'Own Contribution with Expenses', 0, 122449, 83.33, '2017-01-18 05:44:42'),
(6, 2, 'Own Contribution with Expenses', 122449, 666667, 50, '2017-01-18 05:44:45'),
(7, 2, 'Own Contribution with Expenses', 666667, 2812500, 33.33, '2017-01-18 05:44:47'),
(8, 2, 'Own Contribution with Expenses', 2812500, 420000000, 28.57, '2017-01-25 00:49:39'),
(9, 3, 'Loan Amount', 0, 1000000, 98, '2017-01-18 05:46:15'),
(10, 3, 'Loan Amount', 1000000, 3000000, 90, '2017-01-18 05:46:15'),
(11, 3, 'Loan Amount', 3000000, 7500000, 80, '2017-01-18 05:47:24'),
(12, 3, 'Loan Amount', 7500000, 600000000, 75, '2017-01-18 05:47:24'),
(13, 4, 'Property Price', 0, 1020408, 98, '2017-01-18 05:46:15'),
(14, 4, 'Property Price', 1020408, 3333333, 90, '2017-01-18 05:46:15'),
(15, 4, 'Property price', 3333333, 9375000, 80, '2017-01-18 05:47:24'),
(16, 4, 'property Price', 9375000, 8000000000, 75, '2017-01-18 05:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `tp_adm_users`
--

CREATE TABLE IF NOT EXISTS `tp_adm_users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(100) NOT NULL,
  `adminpassword` varchar(100) NOT NULL,
  `adminemail` varchar(100) NOT NULL,
  `is_b2badmin` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tp_adm_users`
--

INSERT INTO `tp_adm_users` (`id`, `adminname`, `adminpassword`, `adminemail`, `is_b2badmin`, `status`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 0, 1, '2014-08-25 23:50:16'),
(2, 'b2b', 'b2badmin', 'b2b@gmail.com', 1, 1, '2016-12-26 01:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_bankmaster`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_bankmaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(150) NOT NULL,
  `bank_logo` varchar(250) NOT NULL,
  `ltv_type` varchar(20) NOT NULL DEFAULT 'rbi_ltv',
  `tier_classification` varchar(20) NOT NULL,
  `rule_engine` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tp_loanap_bankmaster`
--

INSERT INTO `tp_loanap_bankmaster` (`id`, `bank_name`, `bank_logo`, `ltv_type`, `tier_classification`, `rule_engine`) VALUES
(1, 'SBI', '', 'rbi_ltv', 'rbi_tier', 'icici_api'),
(2, 'IDFC', '', 'rbi_ltv', 'rbi_tier', 'propwiser_api');

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_product`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_short_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tp_loanap_product`
--

INSERT INTO `tp_loanap_product` (`id`, `bank_id`, `product_name`, `product_short_name`) VALUES
(1, 1, 'Residential Home Purchase Loan', 'RHPL/HL'),
(2, 1, 'Residential Self Construction Loan', 'RSCL'),
(3, 1, 'Residential Resale Home Loan', 'RRHL'),
(4, 2, 'IDFC Residential Home Loans', 'IDFC/S'),
(5, 2, 'IDFC Commercial Loan', 'IDFC/C'),
(6, 2, 'IDFC Women Plus', 'IDFC / SS'),
(7, 2, 'IDFC Land Property Loan', 'IDFC / MX');

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_rbi_ltv`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_rbi_ltv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_loan_amt` double(10,2) NOT NULL,
  `max_loan_amt` double(10,2) NOT NULL,
  `ltv_percentage` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tp_loanap_rbi_ltv`
--

INSERT INTO `tp_loanap_rbi_ltv` (`id`, `min_loan_amt`, `max_loan_amt`, `ltv_percentage`) VALUES
(1, 0.00, 1000000.00, 98.00),
(2, 1000000.00, 3000000.00, 90.00),
(3, 3000000.00, 7500000.00, 80.00),
(4, 7500000.00, 60000000.00, 75.00);

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_rulemaster`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_rulemaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  `rule_type` varchar(100) NOT NULL,
  `rule` text NOT NULL,
  `fail_message` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tp_loanap_rulemaster`
--

INSERT INTO `tp_loanap_rulemaster` (`id`, `bank_id`, `product_id`, `scheme_id`, `rule_type`, `rule`, `fail_message`) VALUES
(1, 0, 0, 0, 'global', '#age > 21 and #age < 40', 'Age must be greater than 30'),
(2, 0, 0, 0, 'global', '#citytier >= 1 ', 'city tier should be 1'),
(3, 1, 0, 0, 'bank', '#age > 25', 'Age should be greater than 25'),
(4, 1, 0, 0, 'bank', '#citytier = 1', 'Loan Available for tier 1 cities'),
(5, 2, 0, 0, 'bank ', '#age > 22', 'Age should be greater than 22'),
(6, 2, 0, 0, 'bank', '#income > 5000', 'Person income should be greater than 25000'),
(7, 1, 2, 0, 'product', '#emptype = 1 or #emptype = 3', 'Product for Salaried and self employed professional.'),
(8, 1, 3, 0, 'product', '#income > 10000', 'Monthly Income should be greater than 50000.'),
(14, 2, 4, 0, 'product', '#income > 10000', 'Monthly Income should be greater than 20000.'),
(15, 2, 4, 4, 'scheme', '#income > 10000', 'Monthly Income should be greater than 20000.'),
(16, 2, 4, 6, 'scheme', '#emptype = 1', 'Product for Salaried and self employed professional.'),
(17, 2, 4, 5, 'scheme', '#income > 10000', 'test'),
(18, 2, 4, 7, 'scheme', '#income > 10000', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_ruleresult`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_ruleresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  `rule_type` varchar(100) NOT NULL,
  `rule_status` tinyint(1) NOT NULL,
  `fail_message` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=358 ;

--
-- Dumping data for table `tp_loanap_ruleresult`
--

INSERT INTO `tp_loanap_ruleresult` (`id`, `transaction_id`, `rule_id`, `bank_id`, `product_id`, `scheme_id`, `rule_type`, `rule_status`, `fail_message`, `created_at`) VALUES
(351, 0, 5, 2, 0, 0, 'bank ', 1, 'Age should be greater than 22', '2017-08-17 16:20:14'),
(352, 0, 6, 2, 0, 0, 'bank', 1, 'Person income should be greater than 25000', '2017-08-17 16:20:14'),
(353, 0, 14, 2, 4, 0, 'product', 1, 'Monthly Income should be greater than 20000.', '2017-08-17 16:20:14'),
(354, 0, 15, 2, 4, 4, 'scheme', 1, 'Monthly Income should be greater than 20000.', '2017-08-17 16:20:14'),
(355, 0, 16, 2, 4, 6, 'scheme', 1, 'Product for Salaried and self employed professional.', '2017-08-17 16:20:14'),
(356, 0, 17, 2, 4, 5, 'scheme', 1, 'test', '2017-08-17 16:20:14'),
(357, 0, 18, 2, 4, 7, 'scheme', 1, 'test', '2017-08-17 16:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_scheme`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `plan_type` tinyint(4) NOT NULL,
  `scheme_name` varchar(200) NOT NULL,
  `interest_period` tinyint(4) NOT NULL DEFAULT '36',
  `min_loan` double(10,2) NOT NULL,
  `min_tenure` smallint(6) NOT NULL,
  `min_interest_rate` double(10,2) NOT NULL,
  `min_property_price` double(10,2) NOT NULL,
  `max_loan` double(10,2) NOT NULL,
  `max_tenure` smallint(6) NOT NULL,
  `max_interest_rate` double(10,2) NOT NULL,
  `max_property_price` double(10,2) NOT NULL,
  `foir_type` tinyint(1) NOT NULL,
  `foir_value` tinyint(4) NOT NULL,
  `ltv_reduction` float(10,2) NOT NULL,
  `cur_year_multiplier` float(10,2) NOT NULL,
  `prev_year_multiplier` float(10,2) NOT NULL,
  `average_multiplier` float(10,2) NOT NULL,
  `other_income` float(10,2) NOT NULL,
  `remuneration` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tp_loanap_scheme`
--

INSERT INTO `tp_loanap_scheme` (`id`, `product_id`, `plan_type`, `scheme_name`, `interest_period`, `min_loan`, `min_tenure`, `min_interest_rate`, `min_property_price`, `max_loan`, `max_tenure`, `max_interest_rate`, `max_property_price`, `foir_type`, `foir_value`, `ltv_reduction`, `cur_year_multiplier`, `prev_year_multiplier`, `average_multiplier`, `other_income`, `remuneration`) VALUES
(1, 1, 3, 'Normal Income Program', 36, 500000.00, 60, 6.00, 0.00, 10000000.00, 360, 8.50, 0.00, 0, 55, 0.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(2, 1, 2, 'Stepup Program', 36, 500000.00, 60, 0.00, 0.00, 10000000.00, 360, 8.80, 0.00, 0, 55, 5.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(3, 1, 1, 'Simple Loan Program', 36, 500000.00, 60, 5.00, 0.00, 10000000.00, 360, 8.35, 0.00, 0, 55, 1.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(4, 4, 1, 'Simple Loan', 36, 500000.00, 60, 8.55, 0.00, 99999999.99, 300, 8.55, 0.00, 1, 55, 0.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(5, 4, 2, 'Booster Home Loan', 36, 500000.00, 60, 8.55, 0.00, 99999999.99, 300, 8.75, 0.00, 1, 55, 0.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(6, 4, 3, 'Short & Sweet Home Loan', 36, 500000.00, 60, 8.55, 0.00, 99999999.99, 300, 8.55, 0.00, 1, 55, 0.00, 1.00, 1.00, 1.00, 0.00, 0.00),
(7, 4, 4, 'Max Saver Home Loan', 36, 500000.00, 60, 8.55, 0.00, 99999999.99, 300, 8.75, 0.00, 1, 55, 0.00, 1.00, 1.00, 1.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tp_loanap_scheme_foir`
--

CREATE TABLE IF NOT EXISTS `tp_loanap_scheme_foir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) NOT NULL,
  `city_tier` tinyint(4) NOT NULL,
  `employee_type` tinyint(4) NOT NULL,
  `min_monthly` double(10,2) NOT NULL,
  `max_monthly` double(15,2) NOT NULL,
  `foir_percentage` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tp_loanap_scheme_foir`
--

INSERT INTO `tp_loanap_scheme_foir` (`id`, `scheme_id`, `city_tier`, `employee_type`, `min_monthly`, `max_monthly`, `foir_percentage`) VALUES
(1, 4, 1, 1, 1000.00, 50000.00, 50.00),
(2, 4, 1, 1, 50000.00, 100000.00, 55.00),
(3, 4, 1, 1, 100000.00, 99999999.99, 60.00),
(4, 4, 1, 2, 0.00, 99999999.99, 60.00),
(5, 4, 1, 3, 0.00, 99999999.99, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `tp_pmay_rule`
--

CREATE TABLE IF NOT EXISTS `tp_pmay_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `income_from` double(15,2) NOT NULL,
  `income_to` double(15,2) NOT NULL,
  `pmay_cat` varchar(100) NOT NULL,
  `pmay_dec` varchar(200) NOT NULL,
  `subsidy_loan` double(15,2) NOT NULL,
  `subsidy_rate` float NOT NULL,
  `subsisy_amount` double(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tp_pmay_rule`
--

INSERT INTO `tp_pmay_rule` (`id`, `income_from`, `income_to`, `pmay_cat`, `pmay_dec`, `subsidy_loan`, `subsidy_rate`, `subsisy_amount`, `created_at`) VALUES
(1, 0.00, 300000.00, 'EWS', 'Economically Weaker Section', 600000.00, 6.5, 267280.00, '2017-08-17 15:27:42'),
(2, 300001.00, 600000.00, 'LIG', 'Lower Income Group', 600000.00, 6.5, 267280.00, '2017-08-17 15:58:00'),
(3, 600001.00, 1200000.00, 'MIG1', 'Middle Income Group 1', 900000.00, 4, 235068.00, '2017-08-17 15:59:25'),
(4, 1200001.00, 1800000.00, 'MIG2', 'Middle Income Group 2', 1200000.00, 3, 230156.00, '2017-08-17 15:59:28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
