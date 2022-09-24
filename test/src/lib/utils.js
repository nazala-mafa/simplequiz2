import { SERVER_URL } from "./const";

export function addMeta(name, desc) {
  var meta = document.createElement('meta');
  meta.setAttribute('name', name);
  meta.setAttribute('content', desc)
  document.getElementsByTagName('head')[0].appendChild(meta)
}

export function getUser() {
  return fetch(SERVER_URL + "api/user", {
    method: "get",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      Authorization: "Bearer " + localStorage.getItem("token"),
    },
  }).then((res) => res.json())    
}