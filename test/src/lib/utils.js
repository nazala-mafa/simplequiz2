export function addMeta(name, desc) {
  var meta = document.createElement('meta');
  meta.setAttribute('name', name);
  meta.setAttribute('content', desc)
  document.getElementsByTagName('head')[0].appendChild(meta)
}