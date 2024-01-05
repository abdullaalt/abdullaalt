<?php
namespace App\Enums;

enum RusEnums: string{

    case HAVE_NOT_PERMISSIONS = 'Нет доступа';
    case USER_NOT_FOUND = 'Пользователь не найден';
    case NOT_VALID_DATA = 'Неверный логин или пароль';
    case NOT_CONNECTED_WITH_TREE = 'Вы не привязаны к древу';
    case NODE_NOT_FOUND = 'Элемент в древе не найден';
    case TEIP_NOT_FOUND = 'Тейп не найден';
    case INVALID_NODE_ID = 'Неверный идентификатор';
    case GROUP_NOT_FOUND = 'Группа не найдена';

    case POST_NOT_FOUND = 'Пост не найден';
    case VAR_NOT_FOUND = 'Вариант ответа не найден';
    case ALREADY_VOTED = 'Вы уже голосовали';
    case DIDNT_VOTED = 'Вы не голосовали';

    case PICTURE_MARK_TITLE = 'Отметка на фотографии';
    case PICTURE_MARK_BODY = ' отметил Вас на фотографии';

    case COMMENTS_NOT_FOUND = 'Нет комментариев';
    case COMMENT_NOT_FOUND = 'Комментарий не найден';

    case EVENTS_NOT_FOUND = 'Событий не найдено';
    case EVENT_NOT_FOUND = 'Событие не найдено';

    public static function get($key){
        return self::fromName($key);
    }

    public static function fromName(string $name){
        ;
        return constant("self::$name")->value;
    }

}

// class RusEnums{

//     public $USER_NOT_FOUND = 'Пользователь не найден';
//     public $NOT_VALID_DATA = 'Неверный логин или пароль';
//     public $NODE_NOT_FOUND = 'Элемент в древе не найден';
//     public $TEIP_NOT_FOUND = 'Тейп не найден';
//     public $INVALID_NODE_ID = 'Неверный идентификатор';

//     public function get($key){
//         return $this->{$key};
//     }

// }