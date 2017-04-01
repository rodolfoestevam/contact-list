<?php
/**
 * Created by PhpStorm.
 * User: iagobelodeoliveiravieira
 * Date: 31/03/17
 * Time: 20:32
 */

// Imports
require_once '../db/DatabaseFactory.php';

// Database Handler
$db = DatabaseFactory::getDatabase();

// DB Constans
const CONTACT_TABLE = 'contact';
const ID_KEY = 'id';
const NAME_KEY = 'name';
const COMPANY_KEY = 'company';
const ROLE_KEY = 'role';
const CITY_KEY = 'city';
const STATE_KEY = 'state';
const PHONE_KEY = 'phone';
const SKYPE_KEY = 'skype';
const OBSERVATION_KEY = 'observation';

// API Constants
const ALL_METHOD = 'all';
const WORD_METHOD = 'word';
const ID_METHOD = 'id';

// Vars
global $RESULT;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Search contact by id.
        if (isset($_GET[ID_METHOD])) {
            $RESULT = $db->select(CONTACT_TABLE, '*', [ID_KEY => $_GET[ID_KEY]]);
        }

        // Search contacts that contains the received string.
        if (isset($_GET[WORD_METHOD])) {
            $RESULT = $db->select(CONTACT_TABLE, '*',
                [
                    'OR' => [
                        NAME_KEY . '[~]' => $_GET['word'] . '%',
                        COMPANY_KEY . '[~]' => $_GET['word'] . '%',
                        ROLE_KEY . '[~]' => $_GET['word'] . '%',
                        CITY_KEY . '[~]' => $_GET['word'] . '%',
                        STATE_KEY . '[~]' => $_GET['word'] . '%',
                        PHONE_KEY . '[~]' => $_GET['word'] . '%',
                        SKYPE_KEY . '[~]' => $_GET['word'] . '%',
                        OBSERVATION_KEY . '[~]' => $_GET['word'] . '%'
                    ]
                ]
            );
        }

        // Return all contacts.
        if (isset($_GET[ALL_METHOD])) {
            $RESULT = $db->select(CONTACT_TABLE, '*');
        }
        break;

    case 'POST':
        $RESULT = $db->insert(CONTACT_TABLE,
            [
                NAME_KEY => $_POST[NAME_KEY],
                COMPANY_KEY => $_POST[COMPANY_KEY],
                ROLE_KEY => $_POST[ROLE_KEY],
                CITY_KEY => $_POST[CITY_KEY],
                STATE_KEY => $_POST[STATE_KEY],
                PHONE_KEY => $_POST[PHONE_KEY],
                SKYPE_KEY => $_POST[SKYPE_KEY],
                OBSERVATION_KEY => $_POST[OBSERVATION_KEY]
            ]
        );
        break;

//    case 'PUT':
//        parse_str(file_get_contents('php://input'), $_PUT);
//        $RESULT = $db->update(CONTACT_TABLE,
//            [
//                NAME_KEY => $_PUT[NAME_KEY],
//                COMPANY_KEY => $_PUT[COMPANY_KEY],
//                ROLE_KEY => $_PUT[ROLE_KEY],
//                CITY_KEY => $_PUT[CITY_KEY],
//                STATE_KEY => $_PUT[STATE_KEY],
//                PHONE_KEY => $_PUT[PHONE_KEY],
//                SKYPE_KEY => $_PUT[SKYPE_KEY],
//                OBSERVATION_KEY => $_PUT[OBSERVATION_KEY],
//            ],
//            [
//                ID_KEY => $_PUT[ID_KEY]
//            ]
//        );
//        break;
//
//    case 'DELETE':
//        parse_str(file_get_contents('php://input'), $_DELETE);
//        break;

    default:
        http_response_code(405);
}

// Return
if (!empty($RESULT)) {
    echo json_encode($RESULT);
} elseif ($RESULT != 1) {
    http_response_code(500);
} else {
    http_response_code(204);
}