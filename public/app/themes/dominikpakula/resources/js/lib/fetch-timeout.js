/**
 * fetch z limitem czasu (AbortController). Zachowuje się jak zwykły fetch,
 * ale po `timeoutMs` przerywa żądanie — AbortError wpada do catch wywołującego
 * i pokazuje komunikat o błędzie zamiast wiecznego "Wysyłam...".
 */
export function fetchWithTimeout(url, options = {}, timeoutMs = 12000) {
  const controller = new AbortController();
  const timer = setTimeout(() => controller.abort(), timeoutMs);

  return fetch(url, { ...options, signal: controller.signal }).finally(() =>
    clearTimeout(timer),
  );
}
