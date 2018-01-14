import {API_LIST_FIND} from '@/config.js';
import axios from 'axios';

/**
 * Возвращает список фильмов. По заголовку
 *
 * @param {String} title
 * @return {String[]} Список фильмов
 */
export async function sendRequestToListSearch(title) {

  // Правильно ли?!
  if (checkLengthTitle(title)) return null;

  let someList = [];

  return someList = await axios.get(API_LIST_FIND + title)
    .then(data => {return getArrayFilms(data)})
    .catch(data => {
      throw data
    });

}

/**
 * Вернем список фильмов, которые пришли после поиска
 *
 * @param {Object} films
 * @return {Array} уже распаршенный список фильмов
 */
function getArrayFilms(films) {
  return films.data.Search;
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

