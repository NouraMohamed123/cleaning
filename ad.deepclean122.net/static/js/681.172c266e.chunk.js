"use strict";(self.webpackChunkcleaning=self.webpackChunkcleaning||[]).push([[681],{81671:function(e,r,i){i.d(r,{Z:function(){return d}});i(47313);var n=i(2135),t=i(82508),s=i(31095),l=i(61113),a=i(63866),o=i(46417);function c(e){var r=e.children;e.type;return(0,o.jsx)(a.E.div,{whileHover:{scale:1},whileTap:{scale:.9},children:r})}c.defaultProps={type:"scale"};var d=function(e){var r=e.show,i=void 0===r||r,a=e.type,d=void 0===a?"button":a,u=e.variant,h=void 0===u?"contained":u,x=e.size,p=e.width,f=e.fullWidth,m=e.bgcolor,v=e.title,Z=e.path,j=e.icon,g=e.loading,b=e.fun;if(i)switch(d){case"submit":return(0,o.jsx)(c,{children:(0,o.jsxs)(s.Z,{type:"submit",size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(p,"px"),bgcolor:m},children:[(0,o.jsx)(l.Z,{children:v}),g&&(0,o.jsx)(t.Z,{})]})});case"action":return(0,o.jsx)(c,{children:(0,o.jsxs)(s.Z,{type:d,size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(p,"px"),bgcolor:m},onClick:function(){return b()},children:[j,(0,o.jsx)(l.Z,{children:v})]})});default:return(0,o.jsx)(n.rU,{to:Z,children:(0,o.jsx)(c,{children:(0,o.jsxs)(s.Z,{type:d,size:x,disabled:g,fullWidth:f,variant:h,style:{gap:4,width:"".concat(p,"px"),bgcolor:m},children:[j,(0,o.jsx)(l.Z,{children:v})]})})})}}},62937:function(e,r,i){var n,t=i(1413),s=i(29439),l=i(30168),a=i(47313),o=i(58823),c=i(61113),d=i(2905),u=i(46417),h=d.ZP.div(n||(n=(0,l.Z)(["\n  flex: 1;\n  display: flex;\n  flex-direction: column;\n  align-items: center;\n  padding: 30px;\n  border-width: 2px;\n  border-radius: 10px;\n  border-color: ",";\n  border-style: dashed;\n  background-color: #fafafa;\n  color: black;\n  font-weight: bold;\n  font-size: 1rem;\n  outline: none;\n  transition: border 0.24s ease-in-out;\n"])),(function(e){return function(e){return e.isDragAccept?"#40a9ff":e.isDragReject?"#ff1744":e.isFocused?"#2196f3":"#eeeeee"}(e)}));r.Z=function(e){var r=e.height,i=e.value,n=void 0===i?"":i,l=e.onChange,d=e.error,x=e.helperText,p=e.label,f=(0,a.useState)(n),m=(0,s.Z)(f,2),v=m[0],Z=m[1];a.useEffect((function(){Z(n)}),[n]);var j=(0,a.useCallback)((function(e){var r=e[0];l(r);var i=new FileReader;i.onload=function(){var e=i.result;Z(e)},i.readAsDataURL(r)}),[l]),g=(0,o.uI)({accept:"image/*",onDrop:j,noClick:!1,noKeyboard:!0}),b=g.getRootProps,y=g.getInputProps,w=g.isDragAccept,P=g.isFocused,T=g.isDragReject;return(0,u.jsxs)("div",{children:[(0,u.jsxs)(h,(0,t.Z)((0,t.Z)({},b({isDragAccept:w,isFocused:P,isDragReject:T})),{},{children:[(0,u.jsx)("input",(0,t.Z)({},y())),v?(0,u.jsx)("img",{src:v,height:r,style:{maxWidth:"100%"},alt:"Preview"}):(0,u.jsx)("p",{children:p})]})),d&&(0,u.jsx)(c.Z,{sx:{color:"error.main"},children:x})]})}},29814:function(e,r,i){var n=i(29439),t=i(47313),s=i(84488),l=i(42832),a=i(9019),o=i(35628),c=i(46417);r.Z=function(e){var r=e.children,i=(0,t.useState)(!0),d=(0,n.Z)(i,2),u=d[0],h=d[1];(0,t.useEffect)((function(){h(!1)}),[]);var x=(0,c.jsx)(o.Z,{title:(0,c.jsx)(s.Z,{sx:{width:{xs:120,md:180}}}),secondary:(0,c.jsx)(s.Z,{animation:"wave",variant:"circular",width:24,height:24}),children:(0,c.jsxs)(l.Z,{spacing:1,children:[(0,c.jsx)(s.Z,{}),(0,c.jsx)(s.Z,{sx:{height:64},animation:"wave",variant:"rectangular"}),(0,c.jsx)(s.Z,{}),(0,c.jsx)(s.Z,{})]})});return(0,c.jsxs)(c.Fragment,{children:[u&&(0,c.jsxs)(a.ZP,{container:!0,spacing:3,children:[(0,c.jsx)(a.ZP,{item:!0,xs:12,md:6,children:x}),(0,c.jsx)(a.ZP,{item:!0,xs:12,md:6,children:x}),(0,c.jsx)(a.ZP,{item:!0,xs:12,md:6,children:x}),(0,c.jsx)(a.ZP,{item:!0,xs:12,md:6,children:x})]}),!u&&r]})}},5681:function(e,r,i){i.r(r);var n=i(1413),t=i(29439),s=(i(47313),i(85554)),l=i(58467),a=i(73821),o=i(9019),c=i(24631),d=i(42832),u=i(75590),h=i(3463),x=i(62563),p=i(75627),f=i(35628),m=i(29814),v=i(81671),Z=i(62937),j=i(37424),g=i(46417);r.default=function(){var e,r,i,b,y,w=(0,u.$G)("pages"),P=(0,t.Z)(w,1)[0],T=(0,l.s0)(),k=(0,s.I0)(),R=(0,s.v9)((function(e){return e.servicesSlice})).isLoading,W=j.yR,D=j.$8,C=h.Ry().shape({name:h.Z_().nullable().required(P("services.form.name.helperText")),description:h.Z_().required(P("services.form.description.helperText")),price:h.Z_().required(P("services.form.price.helperText")),duration:h.Z_().required(P("services.form.duration.helperText")),photo:h.nK().required(P("services.form.photo.helperText"))}),S=(0,p.cI)({resolver:(0,x.X)(C)}),q=S.register,z=S.handleSubmit,B=S.formState,F=S.reset,A=S.setValue,I=B.errors,_=(0,g.jsx)(v.Z,{title:P("services.btn.back"),path:"/services",bgcolor:"primary.400"});return(0,g.jsx)(m.Z,{children:(0,g.jsx)(f.Z,{title:P("services.form.title.create"),secondary:_,style:{height:"calc(100vh - 110px)",overflowY:"scroll"},children:(0,g.jsx)("form",{onSubmit:z((function(e){return k((0,a.G6)(e)).then((function(e){"fulfilled"!==e.meta.requestStatus?D(P("services.message.error.create")):(F(),W(P("services.message.success.create")),T("/services"))}))})),children:(0,g.jsxs)(o.ZP,{container:!0,spacing:3,children:[(0,g.jsx)(o.ZP,{item:!0,xs:12,children:(0,g.jsx)(Z.Z,{label:P("services.form.photo.label"),height:"100px",onChange:function(e){return A("photo",e)},error:Boolean(I.photo),helperText:null===(e=I.photo)||void 0===e?void 0:e.message})}),(0,g.jsx)(o.ZP,{item:!0,xs:12,md:6,direction:"ltr",children:(0,g.jsx)(c.Z,(0,n.Z)((0,n.Z)({fullWidth:!0,variant:"filled",type:"text",name:"name",label:P("services.form.name.label")},q("name")),{},{error:Boolean(I.name),helperText:null===(r=I.name)||void 0===r?void 0:r.message}))}),(0,g.jsx)(o.ZP,{item:!0,xs:12,md:6,children:(0,g.jsx)(c.Z,(0,n.Z)((0,n.Z)({fullWidth:!0,variant:"filled",type:"number",name:"price",label:P("services.form.price.label")},q("price")),{},{error:Boolean(I.price),helperText:null===(i=I.price)||void 0===i?void 0:i.message}))}),(0,g.jsx)(o.ZP,{item:!0,xs:12,md:6,children:(0,g.jsx)(c.Z,(0,n.Z)((0,n.Z)({fullWidth:!0,variant:"filled",type:"number",name:"duration",label:P("services.form.duration.label")},q("duration")),{},{error:Boolean(I.duration),helperText:null===(b=I.duration)||void 0===b?void 0:b.message}))}),(0,g.jsx)(o.ZP,{item:!0,xs:12,md:6,children:(0,g.jsx)(c.Z,(0,n.Z)((0,n.Z)({fullWidth:!0,multiline:!0,minRows:3,maxRows:5,variant:"filled",type:"text",name:"description",label:P("services.form.description.label")},q("description")),{},{error:Boolean(I.description),helperText:null===(y=I.description)||void 0===y?void 0:y.message}))}),(0,g.jsx)(o.ZP,{item:!0,xs:12,children:(0,g.jsx)(d.Z,{direction:"row-reverse",children:(0,g.jsx)(v.Z,{title:P("services.btn.create"),type:"submit",size:"large",loading:R,width:200})})})]})})})})}}}]);