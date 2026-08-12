/**
 * dataLayer — cienka warstwa nad Google Tag Managerem.
 *
 * Każde zdarzenie konwersji przechodzi przez pushEvent(), żeby nazwy i parametry
 * były w jednym miejscu, a komponenty nie dotykały window.dataLayer bezpośrednio.
 *
 * Push do dataLayer sam w sobie niczego nie śledzi — to tylko kolejka. O tym,
 * czy cokolwiek poleci do Google, decydują tagi w GTM i zgoda z Cookiebota
 * (Consent Mode), więc helper nie musi i nie powinien sprawdzać zgody sam.
 *
 * Kontener bywa nieobecny (puste GTM_CONTAINER_ID, zalogowana redakcja,
 * blokada od adblocka) — wtedy push trafia do zwykłej tablicy i nic się nie dzieje.
 */

/**
 * @param {string} name   Nazwa zdarzenia — ta sama trafia do triggera Custom Event w GTM.
 * @param {Object} params Dodatkowe parametry. Puste wartości są pomijane,
 *                        żeby w GA4 nie lądowały wymiary typu "undefined".
 */
export function pushEvent(name, params = {}) {
  if (!name) return;

  window.dataLayer = window.dataLayer || [];

  const payload = { event: name };

  Object.entries(params).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== '') {
      payload[key] = value;
    }
  });

  window.dataLayer.push(payload);
}

export default pushEvent;
