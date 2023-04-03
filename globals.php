<?php

const ROOT_DIR = __DIR__;
const VIEW_DIR = ROOT_DIR . '/views';
const API_DIR = ROOT_DIR . '/api';
const TEMPLATE_DIR = ROOT_DIR . '/templates';
const PAGE_CONTROLLER = ROOT_DIR . '/page-controllers';

const CATEGORY = 'category';
const ITEM = 'item';
const RECORD = 'record';
const INCOME = 'income';
const NOT_EXIST = -4;
const DELETED = 'dracula';
const VALID_SELECTORS = [CATEGORY, ITEM, RECORD, INCOME];
const VALIDATE_ERROR = -3;
const DB_ERROR = -1;

// it is increadly complex to get the name by using built in date time functions, so this one is obviously superior
const MONTH_NAMES = [
    1 => "Janry",
    2 => "Febry",
    3 => "March",
    4 => "Aprl",
    5 => "May",
    6 => "Jun",
    7 => "July",
    8 => "Augst",
    9 => "Septmbr",
    10 => "Octbr",
    11 => "Novmbr",
    12 => "Decmbr",
];
session_start();