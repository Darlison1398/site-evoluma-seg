let count = 0;
const prefix = 'ki-';
export default {
    data: function () {
        count++;
        return {
            count,
            invalidx: false,
            prefix,
            modelValue: '',
            typex: 'text',
            labelx: '...',
            namex: '',
            idx: '',
            alterado: true,
            ktypex: null,
            commands: [
                { "label": "undo", "icon": "arrow-counterclockwise.svg" },
                { "label": "redo", "icon": "arrow-clockwise.svg" },
                //{ "label": "bold", "icon": "type-bold.svg" },
                //{ "label": "italic", "icon": "type-italic.svg" },
                //{ "label": "underline", "icon": "type-underline.svg" },
                { "label": "removeFormat", "icon": "x-square.svg" },

                //{ "label": "indent", "icon": "text-indent-left.svg" },
                //{ "label": "outdent", "icon": "text-indent-right.svg" },
                //{ "label": "insertunorderedlist", "icon": "list-task.svg" },
                //{ "label": "insertorderedlist", "icon": "list-ol.svg" },
                //{ "label": "justifyleft", "icon": "justify-left.svg" },
                //{ "label": "justifycenter", "icon": "text-center.svg" },
                //{ "label": "justifyFull", "icon": "justify.svg" },
                //{ "label": "justifyright", "icon": "justify-right.svg" },

            ],
        }
    },
    props: [
        'label',
        'name',
        'id',
        'value',
        'type',
        'label',
        'disabled',
        'ktype',
        'class',
        'invalid',
        'required',
    ],
    template: `
      <div class="form-floating mb-3" >
            
            <div class="row">
                <div class="col">
                <span title="Salvar alterações do texto" :class="alterado ? 'btn btn-warning m-1' : 'btn btn-light m-1'" @click.prevent="update"><img src="../lib/svg/check-lg.svg"/> </span>    
                <span title="Limpar texto" class="btn btn-light m-1" @click.prevent="clear"><img src="../lib/svg/x-lg.svg"/> </span>    
                <span title="Ve texto maximizado" class="btn btn-light m-1" @click.prevent="full"><img src="../lib/svg/arrows-fullscreen.svg"/> </span> 
                <span v-for="e in commands " :title="e.label" @mousedown.prevent="(ev)=>{ev.preventDefault();this.command(e.label);}" type="submit" class="btn btn-light m-1"><img :src="'../lib/svg/'+e.icon"/></span>
                </div>
            </div>
      
            <div class="row  m-1 form-floating" >
                <div
                id="editor"
                :class="'form-control'+(this.invalidx?'  is-invalid': '')"
                :disabled="this.$props.disabled" 
                :placeholder="labelx"
                :type="typex"  
                :required="required"
                :ktype="ktypex"
                @click="alterado=true"
                @input="alterado=true"
                style = "min-height: 350px;overflow:auto;text-align: justify"
                ref="blogEdit"
                >
                </div>

                <input 
                k
                :class="'form-control'+(this.invalidx?'  is-invalid': '')"
                :disabled="this.$props.disabled" 
                :placeholder="label"
                type="hiddenx"  
                :name="namex" 
                :id="this.idx"
                :value="modelValue"
                :required="required"
                style="display:none"
                :ktype="ktypex"
                ref="blog"
                />
            
                <label :for="name">{{this.labelx}}</label>
            </div>
 	  </div>
      `,
    mounted() {

        this.namex = this.$props.name || prefix + count;
        this.idx = this.$props.idx || this.namex;
        this.typex = this.$props.type == 'text' ? 'search' : this.$props.type;
        this.labelx = this.$props.label || this.$props.name || this.$props.id || "???";
        this.invalidx = this.$props.required ? true : false;
        this.ktypex = this.$props.ktype ?? null;
        //this.$refs.blog.contentWindow.document.body.designMode = 'on';
        this.editor = new EditorJS({
            /** 
             * Id of Element that should contain the Editor 
             */
            holder: this.$refs.blogEdit,//'editor',
            autofocus: true,
            onReady: () => {
                //     console.log('Editor.js is ready to work!')
                //this.editor.on('click', () => alert('l'));
                this.modelValue = this.$props.type == 'datetime-local' ? new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 1000 * 60)).toISOString().replace(/(.+):.*/, '$1') : (this.$props.value || '');
            },

            // onChange: (ev) => {
            //     this.alterado = true;
            //     console.log(ev,arguments)
            // },
            /** 
             * Available Tools list. 
             * Pass Tool's class or Settings object for each Tool you want to use 
             */
            tools: {
                header: Header,
                // image: {
                // 	class: ImageTool,
                // 	config: {
                // 		types: 'image/*',
                // 		uploader: {
                // 			uploadByFile: function (e) { console.log('e:', e, arguments); },
                // 			uploadByUrl: e => e
                // 		},
                // 		buttonContent: 'Selecione uma imagem',
                // 		endpoints: {
                // 			byFile: 'http://localhost:8008/uploadFile', // Your backend file uploader endpoint
                // 			byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
                // 		}
                // 	}
                // },
                // list: {
                //     class: List,
                //     inlineToolbar: true,
                //     config: {
                //         defaultStyle: 'unordered'
                //     }
                // },
                // table: {
                //     class: Table,
                //     inlineToolbar: true,
                //     config: {
                //         rows: 2,
                //         cols: 3,
                //     },
                // },
                // list: {
                //     class: NestedList,
                //     inlineToolbar: true,
                //     config: {
                //         defaultStyle: 'unordered'
                //     },
                // },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                },
                image: {
                    class: ImageTool,
                    config: {
                        types: 'image/*',
                        captionPlaceholder: 'Legenda',
                        buttonContent: 'Selecione uma imagem',
                        uploader: {
                            uploadByFile: (file) => {
                                this.alterado = true;
                                return new Promise((resolve, reject) => {
                                    const reader = new FileReader();
                                    reader.readAsDataURL(file);
                                    reader.onload = () => {
                                        resizeImage(reader.result)
                                            .then(r =>
                                                resolve(
                                                    { 'success': 1, 'file': { url: r } }
                                                )
                                            );
                                    }
                                    reader.onerror = error => reject(error);
                                });

                            }
                        },
                        // actions: [
                        //     {
                        //         name: 'new_button',
                        //         icon: '<svg>...</svg>',
                        //         title: 'New Button',
                        //         toggle: true,
                        //         action: (name) => {
                        //             alert(`${name} button clicked`);
                        //         }
                        //     }
                        // ]
                    }
                },
                //image: SimpleImage,
                //list: List
            },
        });
        //this.editor.isReady.then(r => this.update());
        //console.log(this.editor)
        //this.editor.events.on('click', () => alert('l'));
        //console.log('this.modelValue:',this.modelValue)
        //  this.editor.render(JSON.parse(this.modelValue));
        // this.editor.render(
        //     {
        //         "time": 1550476186479,
        //         "blocks": [{ "type": "header", "data": { "text": "Register now!", "level": 2 } }],
        //         "version": "2.8.1"
        //     }

        // )
    },
    methods: {
        full() {
            // console.log('full', this.$refs.container);

            if (document.fullscreenElement) {
                this.$refs.blogEdit.exitFullscreen();
            } else {
                this.$refs.blogEdit.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            }
        },
        clear() {
            if (confirm('Deseja apagar todo o texto?')) {
                this.alterado = true;
                this.editor.clear();
            }
        },
        update() {
            // console.log(ev)
            // ev.preventDefault();
            // ev.stopPropagation();

            //modelValue = $event.target.innerHTML
            // this.editor.saver.save()
            //     .then(r => {
            //         let str = '';

            //         r.blocks.map(e => {
            //             switch (e.type) {
            //                 case 'header': {
            //                     str += `<h6>${e.data.text}</h6>`;
            //                 }
            //                     break;
            //                 case 'image': {
            //                     str += `<img src='${e.data.file.url}' title='${e.data.caption}' />`;
            //                 }
            //                     break;
            //                 default: {
            //                     str += `<p>${e.data.text}</p>`;
            //                 }
            //                     break


            //             }
            //         });

            //         this.modelValue = str;// ev.target.innerHTML;
            //     });

            this.editor.saver.save()
                .then(r => {
                    // console.log(r);

                    this.modelValue = JSON.stringify(r);
                    this.alterado = false;
                })
        },
        command(a, b) {
            document.execCommand(a, false, b);
        }

    },
    watch: {

        invalid: function (newVal, oldVal) {
            if (newVal == true)
                this.invalidx = newVal;
        },
        modelValue: function (newVal, oldVal) {
            //console.log(typeof newVal, data, this.editor);
            try {
                let data = JSON.parse(newVal);
                //console.log(typeof newVal, data, this.editor);

                this.editor.isReady.then(r => {
                    if (data)
                        this.editor.render(data);
                    //console.log(data);
                    if (this.$props.required && !data.blocks.length) {
                        this.invalidx = true;
                        this.modelValue = '';//JSON.stringify(data);
                    }
                    else {
                        this.invalidx = false;
                        // try{
                        // this.modelValue = JSON.stringify(data);
                        // }catch(e){console.log(e)}
                    }
                });

            } catch (e) { this.editor.clear(); }

        }
    }

}


async function resizeImage(b64, type, w, qualidade) {
    return new Promise(ok => {

        if (!w) w = 800;
        if (!type) type = 'image/webp';
        let img = new Image();
        img.src = b64;//.replace(/[\u0000-\u001F\u007F-\u009F\u200B]/g, "");//result is base64-encoded Data URI

        img.onload = function (el) {

            let srcEncoded = b64;
            let elem = document.createElement('canvas');//create a canvas
            let ctx = elem.getContext('2d');
            elem.width = img.width;
            elem.height = img.height;
            if (img.width > w) {
                let scaleFactor = w / el.target.width;
                elem.width = w;
                elem.height = el.target.height * scaleFactor;
            }

            ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
            srcEncoded = ctx.canvas.toDataURL(type, qualidade ?? 0.8);
            //ok(srcEncoded.replace(/[\u0000-\u001F\u007F-\u009F]/g, ""));
            ok(srcEncoded.replace(/[\u0000-\u001F\u007F-\u009F]/g, ""));

        }
        img.onerror = (e) => { ok(null); console.warn('Erro ao carregar imagem base64:', b64); }
    });
}