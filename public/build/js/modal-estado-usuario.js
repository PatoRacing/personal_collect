document.addEventListener("DOMContentLoaded",(function(){const e=document.querySelector("#buscador"),t=document.querySelector("#tabla-usuarios");e.addEventListener("input",(function(){const o=e.value.trim().toLowerCase();t.querySelectorAll(".table__tr").forEach(e=>{e.querySelector(".table__td--nombre a").textContent.toLowerCase().includes(o)?e.style.display="table-row":e.style.display="none"})}))}));