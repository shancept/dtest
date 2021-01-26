/**
 * Слить 2 объекта вместе
 * @param obj1 Object
 * @param obj2 Object
 * @return Object
 */
let objectMerge = (obj1, obj2) => {
    let result = {...obj1, ...obj2};
    for (let key in obj1) {
        if(typeof obj1[key] === 'object' && typeof obj2[key] === 'object') {
            result[key] = objectMerge(obj1[key], obj2[key]);
        }
    }
    return result;
};

/**
 * Длина объекта
 * @param obj
 * @return number
 */
let objLength = (obj) => {
    let length = 0, item;
    for (item in obj) {
        length++;
    }
    return length;
};

/**
 * Клонирование объекта
 * @param obj Object
 * @return Object
 */
let objClone = (obj) => {
    let clone = {}, key;
    for (key in obj) {
        clone[key] = obj[key];
    }
    return clone;
};

/**
 * Получить куки по имени
 * @param name String имя куки
 * @return {String, Number}
 */
let getCookie = (name) => {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined
};

/**
 * Возвращает токен из куки
 * @return String
 */
let getToken = () => {
    return getCookie('access-token');
};

let v = (data, attr, def) => {
    if (typeof data[attr] !== 'undefined') {
        return data[attr];
    } else {
        return def
    }
}
export {objectMerge, objLength, objClone, getCookie, getToken, v}