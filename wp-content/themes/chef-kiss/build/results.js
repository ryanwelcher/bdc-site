(()=>{"use strict";var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.React,n=window.wp.element,r=window.wp.domReady;var o=e.n(r);const c=window.wp.coreData,a=({conference:e})=>{const{records:n,isResolving:r}=(0,c.useEntityRecords)("taxonomy","votes");return r?"Loading...":(n.filter((e=>{})),(0,t.createElement)("div",{className:"results"},"RESULTS"))};o()((()=>{const e=document.getElementById("results-display");n.createRoot?(0,n.createRoot)(document.getElementById("results-display")).render((0,t.createElement)(a,{conference:e.dataset?.conference})):(0,n.render)((0,t.createElement)(a,{conference:e.dataset?.conference}),document.getElementById("results-display"))}))})();