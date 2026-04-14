const CACHE_NAME = 'xepaviva-cache-v1';
const urlsToCache = [
  '/',
  'index.php',
  'consumidor.php',
  'feirante.php',
  'login.php',
  'registro.php',
  'buscar-ofertas.php',
  'minhas-reservas.php',
  'minhas-ofertas.php',
  'cadastrar_oferta.php',
  'detalhe_oferta.php',
  'como-funciona.php',
  'manifest.json',
  'assets/css/style.css',
  'assets/css/high-contrast.css',
  'assets/js/app.js',
  'assets/js/high-contrast.js',
  'assets/js/toast.js',
  'assets/js/validacao.js',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
  'https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css',
  'https://cdn.jsdelivr.net/npm/chart.js',
  'assets/images/logo.svg',
  'assets/images/logo-white.svg',
  'assets/images/favicon.svg'
];

// Estratégia: Stale-While-Revalidate
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.open(CACHE_NAME).then(cache => {
      return cache.match(event.request).then(response => {
        const fetchPromise = fetch(event.request).then(networkResponse => {
          // Se a requisição for bem-sucedida, atualizamos o cache
          if (networkResponse && networkResponse.status === 200) {
            cache.put(event.request, networkResponse.clone());
          }
          return networkResponse;
        }).catch(err => {
            // O fetch falhou, o que provavelmente significa que estamos offline.
            // O cache.match já terá retornado o recurso do cache se ele existir.
            console.log('Fetch failed; returning offline page instead.', err);
        });

        // Retorna o recurso do cache imediatamente se existir, 
        // enquanto a requisição de rede tenta atualizar o cache em segundo plano.
        return response || fetchPromise;
      });
    })
  );
});

self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

