import*as e from"@wordpress/interactivity";var t={d:(e,o)=>{for(var r in o)t.o(o,r)&&!t.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:o[r]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const o=(s={getContext:()=>e.getContext,store:()=>e.store},c={},t.d(c,s),c),{state:r}=(0,o.store)("chef-kiss",{callbacks:{isSelected:()=>{const e=(0,o.getContext)();e.isSelected=r.selectedRecipes.includes(e.recipeId)}}});var s,c;