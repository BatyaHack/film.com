// Вот так выглядит плагин, если мы используем модули es6
export default {
  install(Vue, options) {

    Vue.prototype._throtlingFlag = '';

    Vue.prototype.$throtling = function (func, time) {
      clearTimeout(this._throtlingFlag);
      this._throtlingFlag = setTimeout(() => func(), 1000);
    };

    Vue.prototype.$sendConsoleMessage = function (someText) {
      console.log(someText);
    };

  }
}
