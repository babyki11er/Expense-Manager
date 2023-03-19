<?php

const ROOT_DIR = __DIR__;
const VIEW_DIR = ROOT_DIR . '/views/';
const API_DIR = ROOT_DIR . '/api/';
const TEMPLATE_DIR = ROOT_DIR . '/templates/';
const NODE_DIR = ROOT_DIR . '/node_modules/';

const CATEGORY = 'category';
const ITEM = 'item';
const RECORD = 'record';
const INCOME = 'income';
const NOT_EXIST = -4;
const DELETED = 'dracula';
const VALID_SELECTORS = [CATEGORY, ITEM, RECORD, INCOME];
const VALIDATE_ERROR = -3;
const DB_ERROR = -1;
session_start();