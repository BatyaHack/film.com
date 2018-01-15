import {API_LIST_FIND} from '@/config.js';
import axios from 'axios';

/**
 * Возвращает список фильмов. По заголовку
 *
 * @param {String} title
 * @return {String[]} Список фильмов
 */
export async function sendRequestToListSearch(title, page) {

  // Правильно ли?!
  if (checkLengthTitle(title)) return null;

  let someList = [];

  return someList = await axios.get(API_LIST_FIND + title + '&page=' + page)
    .then(data => { return data.data; })
    .catch(data => {
      throw data
    });

}

/**
 * Прововеряем длину заголовка
 *
 * @param {String} title
 * @return {boolean}
 */
function checkLengthTitle(title) {
  const titleLength = 3;
  return title.length < titleLength;
}

