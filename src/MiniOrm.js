/**
 * @access public
 * 
 * @example <caption>Class for indexedDB</caption>
 * let indexOrm = new MiniOrm();
 */
class MiniOrm {

  constructor(dbname = 'films', version = 1) {
    this.DBOpenRequest = window.indexedDB.open(dbname, version);
    this._initTable();
    this.connect = this._successConnect();
  }
  /**
   * @private
   * @todo Generate table in indexedDB
   */
  _initTable() {

    this.DBOpenRequest.onupgradeneeded = function (event) {

      var db = event.target.result;
      var objectStore = db.createObjectStore('film', {keyPath: "id"});

      objectStore.createIndex('title', 'title');
      objectStore.createIndex('year', 'year');
      objectStore.createIndex('rated', 'rated', {unique: false});
      objectStore.createIndex('released', 'released', {unique: false});
      objectStore.createIndex('runtime', 'runtime', {unique: false});
      objectStore.createIndex('plot', 'plot', {unique: false});
      objectStore.createIndex('director', 'director', {unique: false});
      objectStore.createIndex('awards', 'awards', {unique: false});
      objectStore.createIndex('poster', 'poster', {unique: false});
      objectStore.createIndex('imdbrating', 'imdbrating', {unique: false});
      objectStore.createIndex('ratings', 'ratings', {unique: false});
      objectStore.createIndex('imdbid', 'imdbid', {unique: false});
      objectStore.createIndex('poster_color', 'poster_color', {unique: false});
      objectStore.createIndex('created_at', 'created_at', {unique: false});
      objectStore.createIndex('updated_at', 'updated_at', {unique: false});

    }

  }

  /**
   * @private
   * @return {ORMConnect} this is connect to DB
   */
  _successConnect() {

    let self = this;

    return new Promise((resolve, reject) => {
        self.DBOpenRequest.onsuccess = function (evt) {
          resolve(evt);
        }
    });

  }
  /**
   * @public
   * @param {Array} transactionArray list table in DB 
   * @param {string} transaction need solo table
   * @return {objectStore} success connect
   */
  openTransaction(transactionArray = ['film'], transaction = 'film') {
    let db = this.DBOpenRequest.result;
    this.objectStore = db.transaction(transactionArray, 'readwrite').objectStore(transaction);
    return this.objectStore;
  }

  /**
   * @public
   * @param {Function} successFunction function for callback
   */
  getAll(successFunction) {
    this.connect
      .then(evt => {
        this.openTransaction().getAll().onsuccess = function (evt) {
          successFunction(evt);
        }
      });
  }

}

let connectDB = new MiniOrm();

export default connectDB;

//TODO какая же параша. Бляяяя.
