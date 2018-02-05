import * as angular from 'angular';
import Parchment from 'parchment';
import Quill, {
  BoundsStatic, DeltaOperation, Module, Picker, QuillOptionsStatic, RangeStatic, SnowTheme, Theme, Toolbar, Tooltip
} from 'quill';

class FormatUsx {
  static readonly KEYS = new Set<string>(['style', 'altnumber', 'pubnumber', 'caller', 'closed']);

  style?: string;
  altnumber?: string;
  pubnumber?: string;
  caller?: string;
  closed?: string;
}

class Note {
  index: number;
  delta: { ops: DeltaOperation[] };
}

export interface SuggestionsTheme extends Theme {
  suggestionsTooltip: Tooltip;
}

export type DropFunction = (file: File, editor: Quill, event: DragEvent | ClipboardEvent) => void;
export type PasteFunction = (item: DataTransferItem, editor: Quill, event: ClipboardEvent) => void;

export function registerSuggestionsTheme(): void {
  const QuillTooltip = Quill.import('ui/tooltip') as typeof Tooltip;
  const QuillModule = Quill.import('core/module') as typeof Module;
  const QuillSnowTheme = Quill.import('themes/snow') as typeof SnowTheme;
  const QuillToolbar = Quill.import('modules/toolbar') as typeof Toolbar;
  const QuillParchment = Quill.import('parchment') as typeof Parchment;
  const Inline = Quill.import('blots/inline') as typeof Parchment.Inline;
  const Block = Quill.import('blots/block') as typeof Parchment.Block;
  const Scroll = Quill.import('blots/scroll') as typeof Parchment.Scroll;
  const Embed = Quill.import('blots/embed') as typeof Parchment.Embed;
  const BlockEmbed = Quill.import('blots/block/embed') as typeof Parchment.Embed;

  // noinspection JSUnusedLocalSymbols
  let dropElements: HTMLElement[] = [];

  function setFormatUsx(node: HTMLElement, format: FormatUsx): void {
    if (format) {
      for (const key in format) {
        if (format.hasOwnProperty(key) && format[key] != null && typeof format[key] === 'string') {
          node.setAttribute(customAttributeName(key), format[key]);
        }
      }
    }
  }

  function createFormatUsx(node: HTMLElement): FormatUsx {
    const format = new FormatUsx();
    for (const key of FormatUsx.KEYS) {
      if (node.hasAttribute(customAttributeName(key))) {
        format[key] = node.getAttribute(customAttributeName(key));
      }
    }

    return format;
  }

  const customAttributeName = (key: string) => 'data-' + key;

  class VerseEmbed extends Embed {
    static blotName = 'verse';
    static tagName = 'usx-verse';

    static create(value: string): Node {
      const node = super.create(value) as HTMLElement;
      node.innerText = value;
      return node;
    }

    static formats(node: HTMLElement): any {
      return { verse: createFormatUsx(node) };
    }

    static value(node: HTMLElement): any {
      return node.innerText.trim();
    }

    format(name: string, value: any): void {
      if (name === 'verse') {
        const format = value as FormatUsx;
        const elem = this.domNode as HTMLElement;
        setFormatUsx(elem, format);
      } else {
        super.format(name, value);
      }
    }
  }

  class SegmentInline extends Inline {
    static blotName = 'segment';
    static tagName = 'usx-segment';

    static create(value: string): Node {
      const node = super.create(value) as HTMLElement;
      node.setAttribute(customAttributeName('ref'), value);
      return node;
    }

    static formats(node: HTMLElement): string {
      return node.getAttribute(customAttributeName('ref'));
    }

    static value(node: HTMLElement): string {
      return node.getAttribute(customAttributeName('ref'));
    }
  }

  class CharInline extends Inline {
    static blotName = 'char';
    static tagName = 'usx-char';

    static create(value: FormatUsx): Node {
      const node = super.create(value) as HTMLElement;
      setFormatUsx(node, value);
      return node;
    }

    static formats(node: HTMLElement): FormatUsx {
      return createFormatUsx(node);
    }

    static value(node: HTMLElement): FormatUsx {
      return createFormatUsx(node);
    }
  }

  class NoteEmbed extends Embed {
    private static readonly DELTA_KEY = '__note_delta';

    static blotName = 'note';
    static tagName = 'usx-note';

    static create(value: Note): Node {
      const node = super.create(value) as HTMLElement;
      node.innerText = String.fromCharCode(0x61 + value.index);
      node.title = value.delta.ops.reduce((text, op) => text + op.insert, '');
      node[NoteEmbed.DELTA_KEY] = value.delta;
      return node;
    }

    static formats(node: HTMLElement): any {
      return { note: createFormatUsx(node) };
    }

    static value(node: HTMLElement): Note {
      const code = node.innerText.trim().charCodeAt(0);
      return { index: code - 0x61, delta: node[NoteEmbed.DELTA_KEY] };
    }

    format(name: string, value: any): void {
      if (name === 'note') {
        const format = value as FormatUsx;
        const elem = this.domNode as HTMLElement;
        setFormatUsx(elem, format);
      } else {
        super.format(name, value);
      }
    }
  }

  Block.allowedChildren.push(VerseEmbed);
  Block.allowedChildren.push(SegmentInline);

  class ParaBlock extends Block {
    static blotName = 'para';
    static tagName = 'usx-para';

    static create(value: FormatUsx): Node {
      const node = super.create(value) as HTMLElement;
      setFormatUsx(node, value);
      return node;
    }

    static formats(node: HTMLElement): FormatUsx {
      return createFormatUsx(node);
    }

    static value(node: HTMLElement): FormatUsx {
      return createFormatUsx(node);
    }

    format(name: string, value: any): void {
      if (FormatUsx.KEYS.has(name)) {
        this.domNode.setAttribute(customAttributeName(name), value);
      } else {
        super.format(name, value);
      }
    }
  }

  class ChapterEmbed extends BlockEmbed {
    static blotName = 'chapter';
    static tagName = 'usx-chapter';

    static create(value: string): Node {
      const node = super.create(value) as HTMLElement;
      node.innerText = value;
      node.contentEditable = 'false';
      return node;
    }

    static formats(node: HTMLElement): any {
      return { chapter: createFormatUsx(node) };
    }

    static value(node: HTMLElement): string {
      return node.innerText;
    }

    format(name: string, value: any): void {
      if (name === 'chapter') {
        const format = value as FormatUsx;
        const elem = this.domNode as HTMLElement;
        setFormatUsx(elem, format);
      } else {
        super.format(name, value);
      }
    }
  }

  Scroll.allowedChildren.push(ParaBlock);
  Scroll.allowedChildren.push(ChapterEmbed);

  const HighlightClass = new QuillParchment.Attributor.Class('highlight', 'highlight', {
    scope: Parchment.Scope.INLINE
  });

  // Add a suggest tooltip to Quill
  class SuggestionsTooltip extends QuillTooltip {
    static TEMPLATE = '<span class="ql-suggest-tooltip-arrow"></span>';

    constructor(quill: Quill, boundsContainer: BoundsStatic) {
      super(quill, boundsContainer);
      this.root = quill.addContainer('ql-suggest-tooltip');
      this.root.innerHTML = SuggestionsTooltip.TEMPLATE;
      const offset = parseInt(window.getComputedStyle(this.root).marginTop, 10);
      this.quill.root.addEventListener('scroll', () => {
        this.root.style.marginTop = (-1 * this.quill.root.scrollTop) + offset + 'px';
      });
      this.hide();
    }

    position(reference: any): number {
      const shift = (super.position(reference) as number);
      const top = reference.bottom + this.quill.root.scrollTop + 10;
      this.root.style.top = top + 'px';
      const arrow = this.root.querySelector('.ql-suggest-tooltip-arrow') as HTMLElement;
      arrow.style.marginLeft = '';
      if (shift === 0) {
        return shift;
      }
      arrow.style.marginLeft = (-1 * shift - arrow.offsetWidth / 2) + 'px';
    }
  }

  class Suggestions extends QuillModule {
    container: Element;

    constructor(quill: Quill, options: any) {
      super(quill, options);

      // initially container is sibling of <ng-quill-editor>
      const elem = quill.container.parentElement.parentElement.parentElement;
      this.container = elem.querySelector(options.container);
      const suggestionsTooltip = (quill.theme as SuggestionsTheme).suggestionsTooltip;
      suggestionsTooltip.root.appendChild(this.container);
      this.container.addEventListener('click', (event: MouseEvent) => {
        if ((event.target as HTMLAnchorElement).classList.contains('suggestion-help')) {
          suggestionsTooltip.show();
          this.quill.focus();
        }
      });
    }
  }

  interface DropOptions extends QuillOptionsStatic {
    onDrop?: DropFunction;
    onPaste?: PasteFunction;
  }

  // inspired by https://github.com/kensnyder/quill-image-drop-module and
  // https://github.com/immense/quill-drag-and-drop-module
  class DragAndDrop extends QuillModule {
    options: DropOptions;

    constructor(quill: Quill, options: DropOptions) {
      super(quill, options);
      if (options.onDrop) {
        this.options.onDrop = options.onDrop;
        this.quill.root.addEventListener('drop', this.handleDrop.bind(this));
      }

      if (options.onPaste) {
        this.options.onPaste = options.onPaste;
        this.quill.root.addEventListener('paste', this.handlePaste.bind(this));
      }
    }

    handleDrop(event: DragEvent): void {
      if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files.length) {
        if (document.caretRangeFromPoint) {
          const selection = document.getSelection();
          const range = document.caretRangeFromPoint(event.clientX, event.clientY);
          if (selection && range) {
            selection.setBaseAndExtent(range.startContainer, range.startOffset, range.startContainer,
              range.startOffset);
          }
        }

        [].forEach.call(event.dataTransfer.files, (file: File) => {
          if (this.options.onDrop) this.options.onDrop(file, this.quill, event);
        });
      }
      DragAndDrop.clearDropElementClasses();
    }

    handlePaste(event: ClipboardEvent): void {
      if (event.clipboardData && event.clipboardData.items && event.clipboardData.items.length) {
        [].forEach.call(event.clipboardData.items, (item: DataTransferItem) => {
          if (this.options.onPaste) this.options.onPaste(item, this.quill, event);
        });
      }
    }

    static monitorFileDragEvents(): void {
      let dragTimer: number;
      document.addEventListener('dragover', (event: any) => {
        event.preventDefault();
        const dt = event.dataTransfer;
        if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') !== -1 : dt.types.includes('Files'))) {
          const elements = document.getElementsByClassName('ql-editor');
          [].forEach.call(elements, (element: HTMLElement, index: number) => {
            element.classList.add('drop-box');
            if (!element.id) element.id = 'ql-editor-' + index;
            dropElements.push(element);
          });
          window.clearTimeout(dragTimer);
        }
      });

      document.addEventListener('dragleave', (event: DragEvent) => {
        const element = event.target as HTMLElement;
        if (DragAndDrop.isInDropElements(element)) {
          return;
        }

        dragTimer = window.setTimeout(() => {
          DragAndDrop.clearDropElementClasses();
        }, 25);
      });

      document.addEventListener('drop', (event: DragEvent) => {
        event.preventDefault();
        DragAndDrop.clearDropElementClasses();
      });
    }

    private static isInDropElements(element: HTMLElement): boolean {
      let result = false;
      dropElements.forEach(dropElement => {
        if (dropElement.id === element.id || DragAndDrop.isDescendant(dropElement, element)) {
          result = true;
        }
      });
      return result;
    }

    private static isDescendant(parent: HTMLElement, child: HTMLElement): boolean {
      let node = child.parentNode;
      while (node != null) {
        if (node === parent) {
          return true;
        }
        node = node.parentNode;
      }
      return false;
    }

    private static clearDropElementClasses(): void {
      dropElements.forEach(element => element.classList.remove('drop-box'));
      dropElements = [];
    }

  }

  // Customize the Snow theme in Quill
  class SuggestionsSnowTheme extends QuillSnowTheme implements SuggestionsTheme {
    private static pickers: Picker[];

    suggestionsTooltip: Tooltip;

    constructor(quill: Quill, options: QuillOptionsStatic) {
      super(quill, options);
      const QuillSuggestionsTooltip = Quill.import('ui/suggest-tooltip');
      this.suggestionsTooltip = new QuillSuggestionsTooltip(this.quill, this.options.bounds);
    }

    extendToolbar(toolbar: any): void {
      if (toolbar.container.classList.contains('ql-snow')) {
        // hook up the update() method for pickers to the editor-change event
        this.pickers = SuggestionsSnowTheme.pickers;
        this.quill.on('editor-change', () => {
          for (const picker of this.pickers) {
            picker.update();
          }
        });
      } else {
        super.extendToolbar(toolbar);
        SuggestionsSnowTheme.pickers = this.pickers;
      }
    }
  }

  class MultiEditorToolbar extends QuillToolbar {
    private static currentQuill: Quill;

    attach(input: HTMLElement): void {
      let format: string = [].find.call(input.classList, (className: string) => {
        return className.indexOf('ql-') === 0;
      });
      if (!format) return;
      format = format.slice('ql-'.length);
      if (input.tagName === 'BUTTON') {
        input.setAttribute('type', 'button');
      }
      const eventName = input.tagName === 'SELECT' ? 'change' : 'click';
      input.addEventListener(eventName, e => {
        if (MultiEditorToolbar.currentQuill !== this.quill) {
          return;
        }

        let value: string | boolean;
        if (input.tagName === 'SELECT') {
          const select = input as HTMLSelectElement;
          if (select.selectedIndex < 0) return;
          const selected = select.options[select.selectedIndex];
          if (selected.hasAttribute('selected')) {
            value = false;
          } else {
            value = selected.value || false;
          }
        } else {
          const button = input as HTMLButtonElement;
          if (button.classList.contains('ql-active')) {
            value = false;
          } else {
            value = button.value || !input.hasAttribute('value');
          }
          e.preventDefault();
        }
        this.quill.focus();
        const range = this.quill.getSelection();
        if (this.handlers[format] != null) {
          this.handlers[format].call(this, value);
        } else {
          this.quill.format(format, value, Quill.sources.USER);
        }
        this.update(range);
      });
      // TODO use weakmap
      this.controls.push([format, input]);
    }

    update(range: RangeStatic): void {
      // save the last used editor, so the toolbar knows which editor to update
      if (MultiEditorToolbar.currentQuill === this.quill) {
        super.update(range);
      } else if (this.quill.hasFocus()) {
        MultiEditorToolbar.currentQuill = this.quill;
        super.update(range);
      }
    }
  }

  Quill.register('attributors/class/highlight', HighlightClass);
  Quill.register('formats/highlight', HighlightClass);
  Quill.register('formats/segment', SegmentInline);
  Quill.register('blots/verse', VerseEmbed);
  Quill.register('blots/note', NoteEmbed);
  Quill.register('blots/char', CharInline);
  Quill.register('blots/para', ParaBlock);
  Quill.register('blots/chapter', ChapterEmbed);
  Quill.register('blots/scroll', Scroll, true);
  Quill.register('ui/suggest-tooltip', SuggestionsTooltip);
  Quill.register('modules/suggestions', Suggestions);
  Quill.register('modules/dragAndDrop', DragAndDrop);
  Quill.register('modules/toolbar', MultiEditorToolbar, true);
  Quill.register('themes/suggestions', SuggestionsSnowTheme);

  DragAndDrop.monitorFileDragEvents();
}