/**
 * Zwraca URL tylko jeśli używa http(s); w przeciwnym razie null.
 * Chroni przed href="javascript:..." wstrzykniętym przez dane z panelu
 * (tytuły / pola usług renderowane w selektorach booking/voucher).
 */
export function safeHref(url) {
  try {
    const parsed = new URL(url, window.location.origin);

    return parsed.protocol === 'http:' || parsed.protocol === 'https:'
      ? parsed.href
      : null;
  } catch {
    return null;
  }
}
