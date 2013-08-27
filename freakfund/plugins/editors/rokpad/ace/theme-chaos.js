/*
 * Copyright (c) 2010, Ajax.org B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Ajax.org B.V. nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL AJAX.ORG B.V. BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
define('ace/theme/chaos', ['require', 'exports', 'module' , 'ace/lib/dom'], function(require, exports, module) {

exports.isDark = true;
exports.cssClass = "ace-chaos";
exports.cssText = ".ace-chaos .ace_gutter {\
background: #141414;\
color: #595959;\
border-right: 1px solid #282828;\
}\
.ace-chaos .ace_gutter-cell.ace_warning {\
background-image: none;\
background: #FC0;\
border-left: none;\
padding-left: 0;\
color: #000;\
}\
.ace-chaos .ace_gutter-cell.ace_error {\
background-position: -6px center;\
background-image: none;\
background: #F10;\
border-left: none;\
padding-left: 0;\
color: #000;\
}\
.ace-chaos .ace_print-margin {\
border-left: 1px solid #555;\
right: 0;\
background: #1D1D1D;\
}\
.ace-chaos .ace_scroller {\
background-color: #161616;\
}\
.ace-chaos .ace_text-layer {\
cursor: text;\
color: #E6E1DC;\
}\
.ace-chaos .ace_cursor {\
border-left: 2px solid #FFFFFF;\
}\
.ace-chaos .ace_cursor.ace_overwrite {\
border-left: 0px;\
border-bottom: 1px solid #FFFFFF;\
}\
.ace-chaos .ace_marker-layer .ace_selection {\
background: #494836;\
}\
.ace-chaos .ace_marker-layer .ace_step {\
background: rgb(198, 219, 174);\
}\
.ace-chaos .ace_marker-layer .ace_bracket {\
margin: -1px 0 0 -1px;\
border: 1px solid #FCE94F;\
}\
.ace-chaos .ace_marker-layer .ace_active-line {\
background: #333;\
}\
.ace-chaos .ace_gutter-active-line {\
background-color: #222;\
}\
.ace-chaos .ace_invisible {\
color: #404040;\
}\
.ace-chaos .ace_keyword {\
color:#00698F;\
}\
.ace-chaos .ace_keyword.ace_operator {\
color:#FF308F;\
}\
.ace-chaos .ace_constant {\
color:#1EDAFB;\
}\
.ace-chaos .ace_constant.ace_language {\
color:#FDC251;\
}\
.ace-chaos .ace_constant.ace_library {\
color:#8DFF0A;\
}\
.ace-chaos .ace_constant.ace_numeric {\
color:#58C554;\
}\
.ace-chaos .ace_invalid {\
color:#FFFFFF;\
background-color:#990000;\
}\
.ace-chaos .ace_invalid.ace_deprecated {\
color:#FFFFFF;\
background-color:#990000;\
}\
.ace-chaos .ace_support {\
color: #999;\
}\
.ace-chaos .ace_support.ace_function {\
color:#00AEEF;\
}\
.ace-chaos .ace_function {\
color:#00AEEF;\
}\
.ace-chaos .ace_string {\
color:#58C554;\
}\
.ace-chaos .ace_comment {\
color:#555;\
font-style:italic;\
padding-bottom: 0px;\
}\
.ace-chaos .ace_variable {\
color:#997744;\
}\
.ace-chaos .ace_meta.ace_tag {\
color:#BE53E6;\
}\
.ace-chaos .ace_entity.ace_other.ace_attribute-name {\
color:#FFFF89;\
}\
.ace-chaos .ace_markup.ace_underline {\
text-decoration: underline;\
}\
.ace-chaos .ace_fold-widget {\
text-align: center;\
}\
.ace-chaos .ace_fold-widget:hover {\
color: #777;\
}\
.ace-chaos .ace_fold-widget.ace_start,\
.ace-chaos .ace_fold-widget.ace_end,\
.ace-chaos .ace_fold-widget.ace_closed{\
background: none;\
border: none;\
box-shadow: none;\
}\
.ace-chaos .ace_fold-widget.ace_start:after {\
content: '???'\
}\
.ace-chaos .ace_fold-widget.ace_end:after {\
content: '???'\
}\
.ace-chaos .ace_fold-widget.ace_closed:after {\
content: '???'\
}\
.ace-chaos .ace_indent-guide {\
border-right:1px dotted #333;\
margin-right:-1px;\
}\
.ace-chaos .ace_fold { \
background: #222; \
border-radius: 3px; \
color: #7AF; \
border: none; \
}\
.ace-chaos .ace_fold:hover {\
background: #CCC; \
color: #000;\
}\
";

var dom = require("../lib/dom");
dom.importCssString(exports.cssText, exports.cssClass);

});