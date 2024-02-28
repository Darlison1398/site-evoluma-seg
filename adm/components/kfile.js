// function log() {
//     return;
//     Array.from(arguments).map(e => {
//         console.log(e);
//     });
// }

let count = 0;
const prefix = 'ki-';
export default {
    data: function () {
        count++;
        return {
            count,
            modelValue: '',
            invalid: false,
            prefix,
            invalidx: false,
            loading: false,
            modal: { title: "Atenção", text: 'Deseja realmente excluir?' },
            data: [],
            value: '[]',
            requiredx: false,
            dt: new DataTransfer(),
            padrao: false,
        }
    },
    props: [
        'title',
        'name',
        'id',
        'label',
        'type',
        'placeholder',
        'disabled',
        'ktype',
        'required',
        'multiple',
    ],
    template: `
      <div class="form-floating mb-3">

 
        <label :for="label || name || prefix+count" class="form-label">
        {{label || name || prefix+count}}
        </label>
        
        <div class="input-group" >
                <input 
                v-if="padrao ? false : true"
                :k="data.length ?true:false"
                :ktype="ktype"
                :disabled="data.length ?true:false"
                :multiple="multiple"
                accept="image/*"
                @change="change"
                ref="files"
                :disabled="disabled"
                :class="'form-control'+(this.invalidx?'  is-invalid': '')"
                :placeholder="this.$props.placeholder" 
                :type="type"  
                :name="(name || prefix+count)+'[]'" 
                :required="requiredx"
                
                @input="$emit('update:modelValue', $event.target.value)"
                v-on:input="modelValue = $event.target.value"
                aria-describedby="btnResetFile"
                />
                <button title="Limpar imagens" @click="clear" type="button" class="btn btn-warning reset" id="btnResetFile">Limpar Imagens</button>
        </div>     
        
        <div ref='imgs' :style='imgs' class='card my-1 flex' >
            <div v-if="loading" style='    width: 100%;display: flex;    align-items: center;    justify-content: center;'>{{loading}}</div>

            <div v-if="!loading && !padrao" v-for="(e,i) in data" class="card col-3 m-1" style="overflow:hidden;overflow-wrap: initial;" :title="e.name+' - '+e.type">
            
                <div class="card-body text-center"  style="background-image: linear-gradient(to right bottom, rgb(255 255 255), rgb(195 195 195));">
                <img :src="e.img"  class="card-text text-center m-1" :alt="e.name" style="    width: 100%;" >
                </div>
            </div>     

            <div v-if="!loading && padrao"  class="card col-3 m-1" style="overflow:hidden;overflow-wrap: initial;" :title="padrao">
            
            <div class="card-body text-center" style="background-image: linear-gradient(to right bottom, rgb(255 255 255), rgb(195 195 195));">
            <img :src="padrao"  class="card-text text-center m-1" :alt="padrao" style="    width: 100%;" >
            </div>
        </div> 
        </div>        

 	  </div>


    
      `,
    methods: {
        clear() {
            this.modelValue = '';
            this.data = [];
            this.value = '[]';
            this.dt.clearData();
            if (this.$refs.files)
                this.$refs.files.files = this.dt.files;
            this.padrao = null;

        },
        async change(e) {



            let fs = this.$refs.files;
            fs = fs.files;

            if (fs.length) {

                this.$emit('loading', 'Carregando...');
                this.loading = 'Carregando ' + fs.length + ' arquivo(s), aguarde por favor...';


                let prs = [];
                let temp = this.data;
                for (let i = 0; i < fs.length; i++) {
                    let f = fs[i];

                    if (f.type === 'image/svg+xml') {

                        f.img = await toDataUrl(f);

                        if (this.$props.multiple)
                            temp.push(f);
                        else
                            temp = [f];
                        //continue;
                        this.dt.items.add(new File([f], f.name, { type: 'image/svg', lastModified: new Date().getTime() }));
                    }

                    else {
                        prs.push(new Promise(async (ok, err) => {

                            let d = null;
                            //if (f.type !== 'image/svg+xml')//se for svg nao redimenciona
                            d = await resizeFile(f, 1200, 300);//, 'image/webp', 0.8);

                            //let d = await resizeFile(f);






                            //if (d)



                            let file = new File([d.blob], d.blob.name, { type: d.blob.type, lastModified: new Date().getTime() });
                            //console.log(file, file.original)
                            this.dt.items.add(file);

                            if (this.$props.multiple)
                                temp.push({ name: d.blob.name, type: d.blob.type, size: d.blob.size, img: d.thumbs });
                            else
                                temp = [{ name: d.blob.name, type: d.blob.type, size: d.blob.size, img: d.thumbs }];



                            this.loading = (i + 1) + ' de ' + fs.length;
                            ok();
                        })
                        );
                    }

                }



                await Promise.all(prs);


                this.$refs.files.files = this.dt.files;

                this.value = JSON.stringify(temp);
                this.data = temp;
                this.loading = '';
                this.$emit('loading', '');
            }
            else {
                this.data = [];
                this.value = '[]';
            }

        },


    },
    mounted() {
        this.invalidx = this.$props.required ? true : false;
        this.requiredx = this.$props.required ? true : false;

        //this.default = this.$props.defaultx ? true : false;
    },
    watch: {
        invalid: function (newVal, oldVal) {
            if (newVal == true)
                this.invalidx = newVal;
        },
        modelValue: function (newVal, oldVal) {
            if (!newVal) {

                if (this.$props.required)
                    this.invalidx = true;
            } else
                this.invalidx = false;
        },
        data: function (newVal, oldVal) {
            let temp = JSON.parse(JSON.stringify(newVal));
            if (temp.length) {
                this.value = JSON.stringify(temp);
            }
            this.loading = false;
        },
    },

    computed: {

        imgs() {
            return {
                "background-color": '#fafafa',
                height: `200px`,
                'overflow': 'auto',
                'display': 'flex',
                'flex-direction': 'row',
            };
        },
    }

}


// const toBase64 = async file => new Promise(async (resolve, reject) => {
//     const reader = new FileReader();
//     reader.readAsDataURL(file);
//     reader.onload = () => resolve(reader.result);
//     reader.onerror = error => reject(error);
// });


// async function resizeImage(b64, type, w, qualidade) {
//     return new Promise(ok => {

//         if (!w) w = 1024;
//         let img = new Image();
//         img.src = b64;//.replace(/[\u0000-\u001F\u007F-\u009F\u200B]/g, "");//result is base64-encoded Data URI

//         img.onload = function (el) {

//             let srcEncoded = b64;
//             let elem = document.createElement('canvas');//create a canvas
//             let ctx = elem.getContext('2d');
//             elem.width = img.width;
//             elem.height = img.height;
//             if (img.width > w) {
//                 let scaleFactor = w / el.target.width;
//                 elem.width = w;
//                 elem.height = el.target.height * scaleFactor;
//             }

//             ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
//             srcEncoded = ctx.canvas.toDataURL(type, qualidade ?? 1);
//             //ok(srcEncoded.replace(/[\u0000-\u001F\u007F-\u009F]/g, ""));
//             ok(srcEncoded.replace(/[\u0000-\u001F\u007F-\u009F]/g, ""));

//         }
//         img.onerror = (e) => { ok(null); console.warn('Erro ao carregar imagem base64:', b64); }
//     });
// }



// async function fileToBase64Resize(e, w, qualidade) {
//     return new Promise(async ok => {

//         let canvas = document.createElement("canvas");
//         let ctx = canvas.getContext("2d");
//         let cw = canvas.width;
//         let ch = canvas.height;
//         let maxW = w ?? 1024;
//         let maxH = w ?? 1024;

//         let img = new Image;
//         img.onload = function () {
//             let iw = img.width;
//             let ih = img.height;
//             canvas.width = iw;
//             canvas.height = ih;
//             if (img.width > w) {
//                 let scale = Math.min((maxW / iw), (maxH / ih));
//                 canvas.width = iw * scale;
//                 canvas.height = ih * scale;
//             }
//             ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
//             ok(canvas.toDataURL(e.type));
//         }
//         img.src = URL.createObjectURL(e);
//     })
// }


async function resizeFile(file, max, maxThumbs, tipo, qualidade) {
    return new Promise(async (ok, err) => {


        max = max ?? 1200;
        maxThumbs = maxThumbs ?? 300;
        qualidade = qualidade ?? 0.8;

        let d = { original: { size: file.size, name: file.name, type: file.type }, blob: null, thumbs: null };

        tipo = tipo ?? d.original.type;


        let reader = new FileReader();
        reader.onload = function (readerEvent) {


            let image = new Image();
            image.onload = function () {

                // Resize image
                let canvas = document.createElement('canvas'),
                    width = image.width,
                    height = image.height;
                if (width > height) {
                    if (width > max) {
                        height *= max / width;
                        width = max;
                    }
                } else {
                    if (height > max) {
                        width *= max / height;
                        height = max;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(image, 0, 0, width, height);



                canvas.toBlob(function (blob) {

                    blob.name = d.original.name;
                    d.blob = blob;

                    d.compact = Math.round(100 - ((blob.size / d.original.size) * 100)) + '%';

                    {
                        max = maxThumbs;
                        if (width > height) {
                            if (width > max) {
                                height *= max / width;
                                width = max;
                            }
                        } else {
                            if (height > max) {
                                width *= max / height;
                                height = max;
                            }
                        }
                        canvas.width = width;
                        canvas.height = height;
                        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                        d.thumbs = canvas.toDataURL(tipo, qualidade);

                    }
                    ok(d);
                    return d;

                }, tipo, qualidade);


            }
            image.src = readerEvent.target.result;


        }
        reader.readAsDataURL(file);





    });
}

const toDataUrl = file => new Promise((resolve, reject) => {

    // Access 'file' with 'FileReader'.
    const reader = new FileReader();

    // Read 'file' with 'readAsDataURL' to produce a base64 string.
    reader.readAsDataURL(file);

    // If the promise resolves: 'result' holds 'file' as a base64 string.
    reader.onload = () => resolve(reader.result);

    // If the promise is rejected: throw an error. 
    reader.onerror = error => reject(error);
});