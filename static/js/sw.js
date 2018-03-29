const CACHE_NAME = 'film-com-application';
const urlsToCache = [
  'app.js',
  'index.html',
  'static/js/test.js',
];

// устанавливаем обработчик на установку воркера
self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function (cache) {
        return cache.addAll(urlsToCache);
      })
  );
});

// если воркер уже установлен то он попытается начать работу
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {

        if (response) {
          return response;
        }

        var fetchRequest = event.request.clone();

        return fetch(fetchRequest).then(
          function (response) {
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function (cache) {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        )

      })
  );
});


self.addEventListener('active', function () {
  console.log('I`m alive');
});
