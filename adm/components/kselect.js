

let count = 0;
const prefix = 'ks-';

function convert(s) {
    return s.split(/\s*;\s*/).map(e => { return { ds: e.match(/^\s*(.*?)\s*,/)[1], id: e.match(/\s*,\s*(.*)\s*/)[1] } });
}

export default {
    data: function () {
        count++;
        return {
            count,
            invalidx: false,
            prefix,
            modelValue: '',
            typex: 'select',
            labelx: '...',
            namex: '',
            idx: '',
            ktypex: null,
            options: (this.$props.options),
            convert,
        }
    },
    props: [

        'label',
        'name',
        'id',
        'value',
        'label',
        'disabled',
        'ktype',
        'class',
        'invalid',
        'required',
        'nulo',
        'link',

    ],
    mounted() {
        this.modelValue = this.$props.type == 'datetime-local' ? new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 1000 * 60)).toISOString().replace(/(.+):.*/, '$1') : (this.$props.value || '')
        this.namex = this.$props.name || prefix + count;
        this.idx = this.$props.idx || this.namex;
        this.typex = this.$props.type == 'text' ? 'search' : this.$props.type;
        this.labelx = this.$props.label || this.$props.name || this.$props.id || "???";
        this.invalidx = this.$props.required ? true : false;
        this.ktypex = this.$props.ktype ?? null;
    },
    methods: {

    },
    created() {

    },
    watch: {
        invalid: function (newVal, oldVal) {
            if (newVal == true)
                this.invalidx = newVal;
        },
        modelValue: function (newVal, oldVal) {
            if (!newVal && this.$props.required)
                this.invalidx = true;
            else
                this.invalidx = false;
        }
    },
    template: `
        <div class="form-floating mb-3 input-group">

            <select 
                k
                :class="'form-control'+(this.invalidx?'  is-invalid': '')"
                :disabled="this.$props.disabled" 
                :placeholder="label"
                :name="namex" 
                :id="idx"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                v-on:input="modelValue = $event.target.value"
                :required="required"
                :ktype="ktypex"
                style="z-index:0;"
                >
                <option selected  ></option>
                <option v-if='nulo' value='null' >NULO</option>
                <option v-for="e in options" :value="e.key" >{{e.label}}</option>
                
            </select>
            <label class="input-group-prepend" :for="name">{{this.$props.label ||this.$props.title || this.$props.name || this.$props.id || prefix+count}}</label>
            <a title="Abrir Cadastro" v-if="this.$props.link ? true : false" class="input-group-append" :href="'?tabela='+this.$props.link" class="btn  btn-primary" ><h3>📝</h3></a>
       </div>
      `
}