"use strict";(self.webpackChunkcleaning=self.webpackChunkcleaning||[]).push([[582],{81671:function(e,n,i){i.d(n,{Z:function(){return d}});i(47313);var t=i(2135),r=i(82508),s=i(31095),l=i(61113),c=i(63866),a=i(46417);function o(e){var n=e.children;e.type;return(0,a.jsx)(c.E.div,{whileHover:{scale:1},whileTap:{scale:.9},children:n})}o.defaultProps={type:"scale"};var d=function(e){var n=e.show,i=void 0===n||n,c=e.type,d=void 0===c?"button":c,u=e.variant,h=void 0===u?"contained":u,x=e.size,j=e.width,f=e.fullWidth,m=e.bgcolor,v=e.title,Z=e.path,p=e.icon,g=e.loading,w=e.fun;if(i)switch(d){case"submit":return(0,a.jsx)(o,{children:(0,a.jsxs)(s.Z,{type:"submit",size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(j,"px"),bgcolor:m},children:[(0,a.jsx)(l.Z,{children:v}),g&&(0,a.jsx)(r.Z,{})]})});case"action":return(0,a.jsx)(o,{children:(0,a.jsxs)(s.Z,{type:d,size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(j,"px"),bgcolor:m},onClick:function(){return w()},children:[p,(0,a.jsx)(l.Z,{children:v})]})});default:return(0,a.jsx)(t.rU,{to:Z,children:(0,a.jsx)(o,{children:(0,a.jsxs)(s.Z,{type:d,size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(j,"px"),bgcolor:m},children:[p,(0,a.jsx)(l.Z,{children:v})]})})})}}},40573:function(e,n,i){i.d(n,{Z:function(){return N}});var t=i(29439),r=i(47313),s=i(2135),l=i(42832),c=i(61689),a=i(47131),o=i(31741),d=i(12019),u=i(47515),h=i(1413),x=i(43295),j=i.n(x),f=i.p+"static/media/printing.08acd6a4106841a511ad.mp3",m=i(31774),v=i(61113),Z=i(24278),p=i(12768),g=i(46417),w=(0,Z.Z)((function(e){return{root:{width:"210mm",height:"297mm",margin:"auto",padding:e.spacing(2),fontFamily:"Cairo, sans-serif",fontSize:"12pt",lineHeight:"1.5",boxSizing:"border-box",border:"1px solid #000",direction:"rtl"},header:{display:"flex",justifyContent:"space-between",marginBottom:e.spacing(4)},content:{textAlign:"justify"},footer:{position:"fixed",bottom:e.spacing(2),width:"100%",textAlign:"center"},ul:{listStyleType:"none",padding:0,margin:0}}})),y=function(e){var n=e.content,i=w();return(0,g.jsxs)("div",{className:i.root,children:[(0,g.jsxs)("div",{className:i.header,children:[(0,g.jsx)("div",{children:(0,g.jsxs)("ul",{className:i.ul,children:[(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{variant:"h5",children:"\u0634\u0631\u0643\u0629 \u0642\u0637\u0648\u0646"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"\u0633 \u062a : 123456789"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"\u0631\u0642\u0645 \u0627\u0644\u0636\u0631\u064a\u0628\u064a : 312242211234543"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"\u0627\u0644\u0623\u062f\u0627\u0631\u0629 : +96643223321"})})]})}),(0,g.jsx)(p.Z,{}),(0,g.jsx)("div",{dir:"ltr",children:(0,g.jsxs)("ul",{className:i.ul,children:[(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{variant:"h5",children:"QOTOON COMPANY"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"CR : 123456789"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"VAT : 312242211234543"})}),(0,g.jsx)("li",{children:(0,g.jsx)(v.Z,{children:"Contact : +96643223321"})})]})})]}),(0,g.jsx)("div",{className:i.content,children:(0,g.jsx)(v.Z,{variant:"body1",children:n})}),(0,g.jsx)("div",{className:i.footer,children:(0,g.jsx)(v.Z,{variant:"body2",children:"\u062d\u0642\u0648\u0642 \u0627\u0644\u0646\u0634\u0631 \xa9 2024"})})]})},b=r.forwardRef((function(e,n){return(0,g.jsx)("div",{ref:n,children:(0,g.jsx)(y,(0,h.Z)({},e))})})),C=function(e){var n=e.content,i=e.playSound,t=e.setPlaySound,s=r.useRef();i&&(new Audio(f).play(),t(!1));return(0,g.jsxs)("div",{children:[(0,g.jsx)(j(),{trigger:function(){return(0,g.jsx)(m.Z,{style:{fontSize:"1.2em"}})},content:function(){return s.current}}),(0,g.jsx)("div",{style:{display:"none"},children:(0,g.jsx)(b,{ref:s,content:n})})]})},S=i(97299),N=function(e){var n=e._view,i=e._edit,h=e._print,x=e._delete,j=r.useState(!1),f=(0,t.Z)(j,2),m=f[0],v=f[1],Z=S.Z;return(0,g.jsxs)(l.Z,{direction:"row",justifyContent:"center",alignItems:"center",children:[(null===n||void 0===n?void 0:n.show)&&(0,g.jsx)(c.Z,{title:"\u0639\u0631\u0636",arrow:!0,children:(0,g.jsx)(s.rU,{to:n.path,children:(0,g.jsx)(a.Z,{sx:{color:"primary.main"},children:(0,g.jsx)(o.Z,{})})})}),(null===h||void 0===h?void 0:h.show)&&(0,g.jsx)(c.Z,{title:"\u0637\u0628\u0627\u0639\u0629",arrow:!0,children:(0,g.jsx)(a.Z,{sx:{color:"warning.main"},onClick:function(){return v(!0)},children:(0,g.jsx)(C,{content:h.content,playSound:m,setPlaySound:v})})}),(null===i||void 0===i?void 0:i.show)&&(0,g.jsx)(c.Z,{title:"\u062a\u0639\u062f\u064a\u0644",arrow:!0,children:(0,g.jsx)(s.rU,{to:i.path,children:(0,g.jsx)(a.Z,{sx:{color:"success.main"},children:(0,g.jsx)(d.Z,{})})})}),(null===x||void 0===x?void 0:x.show)&&(0,g.jsx)(c.Z,{title:"\u062d\u0630\u0641",arrow:!0,children:(0,g.jsx)(a.Z,{sx:{color:"error.main"},onClick:function(){return Z(x.fun,"\u0641\u064a \u062d\u0627\u0644\u0629 \u0627\u0644\u062d\u0630\u0641 \u0644\u0646 \u062a\u062a\u0645\u0643\u0646 \u0645\u0646 \u0627\u0644\u0639\u0648\u062f\u0629 \u0625\u0644\u064a \u0647\u0630\u0627.")},children:(0,g.jsx)(u.Z,{})})})]})}},74338:function(e,n,i){var t=i(29439),r=i(47313),s=i(42832),l=i(41806),c=i(99727),a=(i(78286),i(74294),i(81671)),o=i(24585),d=i(46417),u=function(e){var n=e.columns,i=e.rows,u=e.toolbar,h=(0,r.useState)(null),x=(0,t.Z)(h,2),j=x[0],f=x[1];return(0,d.jsxs)(s.Z,{spacing:.5,children:[u&&(0,d.jsx)(l.Z,{width:"fit-content",children:(0,d.jsx)(a.Z,{type:"action",bgcolor:"secondary.200",size:"small",title:"\u062a\u0635\u062f\u064a\u0631",icon:(0,d.jsx)(o.Z,{}),fun:function(){j&&j.exportDataAsCsv({processCellCallback:function(e){return e.value}})}})}),(0,d.jsx)(l.Z,{className:"ag-theme-quartz",sx:{height:u?"calc(100vh - 260px)":"calc(100vh - 225px)","& .ag-header-cell-label":{justifyContent:"center"}},children:(0,d.jsx)(c.AgGridReact,{rowData:i,columnDefs:n,enableRtl:"rtl",onGridReady:function(e){f(e.api)},defaultColDef:{sortable:!0}})})]})};u.defaultProps={columns:[],rows:[],toolbar:!0},n.Z=u},29814:function(e,n,i){var t=i(29439),r=i(47313),s=i(84488),l=i(42832),c=i(9019),a=i(35628),o=i(46417);n.Z=function(e){var n=e.children,i=(0,r.useState)(!0),d=(0,t.Z)(i,2),u=d[0],h=d[1];(0,r.useEffect)((function(){h(!1)}),[]);var x=(0,o.jsx)(a.Z,{title:(0,o.jsx)(s.Z,{sx:{width:{xs:120,md:180}}}),secondary:(0,o.jsx)(s.Z,{animation:"wave",variant:"circular",width:24,height:24}),children:(0,o.jsxs)(l.Z,{spacing:1,children:[(0,o.jsx)(s.Z,{}),(0,o.jsx)(s.Z,{sx:{height:64},animation:"wave",variant:"rectangular"}),(0,o.jsx)(s.Z,{}),(0,o.jsx)(s.Z,{})]})});return(0,o.jsxs)(o.Fragment,{children:[u&&(0,o.jsxs)(c.ZP,{container:!0,spacing:3,children:[(0,o.jsx)(c.ZP,{item:!0,xs:12,md:6,children:x}),(0,o.jsx)(c.ZP,{item:!0,xs:12,md:6,children:x}),(0,o.jsx)(c.ZP,{item:!0,xs:12,md:6,children:x}),(0,o.jsx)(c.ZP,{item:!0,xs:12,md:6,children:x})]}),!u&&n]})}},24870:function(e,n,i){i.r(n);var t,r=i(29439),s=i(47313),l=i(85554),c=i(82138),a=i(26805),o=i(37424),d=i(75590),u=i(29814),h=i(35628),x=i(74338),j=i(40573),f=i(81671),m=i(35551),v=i.n(m),Z=i(46417),p=(null===(t=v()().get("user_cleaning_details"))||void 0===t?void 0:t.permission)||[];n.default=function(){var e=(0,d.$G)("pages"),n=(0,r.Z)(e,1)[0],i=(0,l.I0)(),t=(0,l.v9)((function(e){return e.permissionsSlice})),m=t.permissionsData,v=t.isLoading,g=o.yR,w=o.$8;s.useEffect((function(){i((0,a.IN)(1))}),[i]);var y=[{field:"#",width:100,cellStyle:{textAlign:"center"},cellRenderer:function(e){return e.node.rowIndex++}},{field:"name",headerName:n("permissions.table.columns.name"),minWidth:150,flex:1,cellStyle:{textAlign:"center"}},{field:"id",headerName:n("permissions.table.columns.actions"),cellRenderer:function(e){return(0,Z.jsx)(j.Z,{_view:{show:p.includes("roles-list"),path:"view/".concat(e.value)},_edit:{show:p.includes("update-role"),path:"edit/".concat(e.value)},_delete:{show:p.includes("delete-role"),fun:function(){return i((0,a.g1)(Number(e.value))).then((function(e){"fulfilled"!==e.meta.requestStatus?w(n("permissions.message.error.delete")):g(n("permissions.message.success.delete"))}))}}})}}],b=(0,Z.jsx)(f.Z,{title:n("permissions.btn.create"),show:p.includes("add-role"),path:"create",icon:(0,Z.jsx)(c.Z,{}),bgcolor:"primary.400"});return(0,Z.jsx)(u.Z,{children:(0,Z.jsx)(h.Z,{title:n("permissions.heading.title"),secondary:b,children:(0,Z.jsx)(x.Z,{columns:y,rows:m,isLoading:v,toolbar:!1})})})}},82138:function(e,n,i){i.d(n,{Z:function(){return a}});var t=i(1413),r=i(47313),s={icon:{tag:"svg",attrs:{viewBox:"64 64 896 896",focusable:"false"},children:[{tag:"defs",attrs:{},children:[{tag:"style",attrs:{}}]},{tag:"path",attrs:{d:"M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"}},{tag:"path",attrs:{d:"M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"}}]},name:"plus",theme:"outlined"},l=i(20262),c=function(e,n){return r.createElement(l.Z,(0,t.Z)((0,t.Z)({},e),{},{ref:n,icon:s}))};c.displayName="PlusOutlined";var a=r.forwardRef(c)}}]);