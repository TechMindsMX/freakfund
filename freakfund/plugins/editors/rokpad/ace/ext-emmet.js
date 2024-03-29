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
define('ace/ext/emmet', ['require', 'exports', 'module' , 'ace/keyboard/hash_handler', 'ace/editor', 'ace/config'], function(require, exports, module) {

var HashHandler = require("ace/keyboard/hash_handler").HashHandler;
var Editor = require("ace/editor").Editor;
var emmet;

Editor.prototype.indexToPosition = function(index) {
    return this.session.doc.indexToPosition(index);
};

Editor.prototype.positionToIndex = function(pos) {
    return this.session.doc.positionToIndex(pos);
};
function AceEmmetEditor() {}

AceEmmetEditor.prototype = {
    setupContext: function(editor) {
        this.ace = editor;
        this.indentation = editor.session.getTabString();
        emmet.require('resources').setVariable('indentation', this.indentation);
        this.$syntax = null;
        this.$syntax = this.getSyntax();
    },
    getSelectionRange: function() {
        var range = this.ace.getSelectionRange();
        return {
            start: this.ace.positionToIndex(range.start),
            end: this.ace.positionToIndex(range.end)
        };
    },
    createSelection: function(start, end) {
        this.ace.selection.setRange({
            start: this.ace.indexToPosition(start),
            end: this.ace.indexToPosition(end)
        });
    },
    getCurrentLineRange: function() {
        var row = this.ace.getCursorPosition().row;
        var lineLength = this.ace.session.getLine(row).length;
        var index = this.ace.positionToIndex({row: row, column: 0});
        return {
            start: index,
            end: index + lineLength
        };
    },
    getCaretPos: function(){
        var pos = this.ace.getCursorPosition();
        return this.ace.positionToIndex(pos);
    },
    setCaretPos: function(index){
        var pos = this.ace.indexToPosition(index);
        this.ace.clearSelection();
        this.ace.selection.moveCursorToPosition(pos);
    },
    getCurrentLine: function() {
        var row = this.ace.getCursorPosition().row;
        return this.ace.session.getLine(row);
    },
    replaceContent: function(value, start, end, noIndent) {
        if (end == null)
            end = start == null ? content.length : start;
        if (start == null)
            start = 0;
        var utils = emmet.require('utils');
        if (!noIndent) {
            value = utils.padString(value, utils.getLinePaddingFromPosition(this.getContent(), start));
        }
        var tabstopData = emmet.require('tabStops').extract(value, {
            escape: function(ch) {
                return ch;
            }
        });

        value = tabstopData.text;
        var firstTabStop = tabstopData.tabstops[0];

        if (firstTabStop) {
            firstTabStop.start += start;
            firstTabStop.end += start;
        } else {
            firstTabStop = {
                start: value.length + start,
                end: value.length + start
            };
        }

        var range = this.ace.getSelectionRange();
        range.start = this.ace.indexToPosition(start);
        range.end = this.ace.indexToPosition(end);

        this.ace.session.replace(range, value);

        range.start = this.ace.indexToPosition(firstTabStop.start);
        range.end = this.ace.indexToPosition(firstTabStop.end);
        this.ace.selection.setRange(range);
    },
    getContent: function(){
        return this.ace.getValue();
    },
    getSyntax: function() {
        if (this.$syntax)
            return this.$syntax;
        var syntax = this.ace.session.$modeId.split("/").pop();
        if (syntax == 'html' || syntax == "php") {
            var cursor = this.ace.getCursorPosition();
            var state = this.ace.session.getState(cursor.row);
            if (typeof state != "string")
                state = state[0];
            if (state) {
                state = state.split("-");
                if (state.length > 1)
                    syntax = state[0];
                else if (syntax == "php")
                    syntax = "html"
            }
        }
        return syntax;
    },
    getProfileName: function() {
        switch(this.getSyntax()) {
          case 'css': return css;
          case 'xml':
          case 'xsl':
            return 'xml';
          case 'html':
            var profile = emmet.require('resources').getVariable('profile');
            if (!profile)
                profile = this.ace.session.getLines(0,2).join("").search(/<!DOCTYPE[^>]+XHTML/i) != -1 ? 'xhtml': 'html';
            return profile;
        }
        return 'xhtml';
    },
    prompt: function(title) {
        return prompt(title);
    },
    getSelection: function() {
        return this.ace.session.getTextRange();
    },
    getFilePath: function() {
        return '';
    }
};


var keymap = {
    expand_abbreviation: {"mac": "ctrl+alt+e", "win": "alt+e"},
    match_pair_outward: {"mac": "ctrl+d", "win": "ctrl+,"},
    match_pair_inward: {"mac": "ctrl+j", "win": "ctrl+shift+0"},
    matching_pair: {"mac": "ctrl+alt+j", "win": "alt+j"},
    next_edit_point: "alt+right",
    prev_edit_point: "alt+left",
    toggle_comment: {"mac": "command+shift+/", "win": "ctrl+shift+/"},
    split_join_tag: {"mac": "shift+command+'", "win": "shift+ctrl+`"},
    remove_tag: {"mac": "command+'", "win": "shift+ctrl+;"},
    evaluate_math_expression: {"mac": "shift+command+y", "win": "shift+ctrl+y"},
    increment_number_by_1: "ctrl+up",
    decrement_number_by_1: "ctrl+down",
    increment_number_by_01: "alt+up",
    decrement_number_by_01: "alt+down",
    increment_number_by_10: {"mac": "alt+command+up", "win": "shift+alt+up"},
    decrement_number_by_10: {"mac": "alt+command+down", "win": "shift+alt+down"},
    select_next_item: {"mac": "shift+command+.", "win": "shift+ctrl+."},
    select_previous_item: {"mac": "shift+command+,", "win": "shift+ctrl+,"},
    reflect_css_value: {"mac": "shift+command+r", "win": "shift+ctrl+r"},

    encode_decode_data_url: {"mac": "shift+ctrl+d", "win": "ctrl+'"},
    expand_abbreviation_with_tab: "Tab"
};

var editorProxy = new AceEmmetEditor();
exports.commands = new HashHandler();
function runEmmetCommand(editor) {
    editorProxy.setupContext(editor);
    if (editorProxy.getSyntax() == "php")
        return false;
    var actions = emmet.require('actions')

    try {
        var result = actions.run(this.name, editorProxy);
    } catch(e) {
        editor._signal("changeStatus", typeof e == "string" ? e : e.message);
    }
    return result;
}

for (var command in keymap) {
    exports.commands.addCommand({
        name: command,
        bindKey: keymap[command],
        exec: runEmmetCommand
    });
}

var onChangeMode = function(e, target) {
    var editor = target;
    if (!editor)
        return;
    var modeId = editor.session.$modeId;
    var enabled = modeId && /css|less|sass|html|php/.test(modeId);
    if (e.enableEmmet === false)
        enabled = false;
    if (enabled)
        editor.keyBinding.addKeyboardHandler(exports.commands);
    else
        editor.keyBinding.removeKeyboardHandler(exports.commands);
};


exports.AceEmmetEditor = AceEmmetEditor
require("ace/config").defineOptions(Editor.prototype, "editor", {
    enableEmmet: {
        set: function(val) {
            this[val ? "on" : "removeListener"]("changeMode", onChangeMode);
            onChangeMode({enableEmmet: !!val}, this);
        },
        value: true
    }
});


exports.setCore = function(e) {emmet = e;};
});

