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
            ktypex: null,
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
      <div class="form-floating mb-3">
			<textarea
            k
            :class="'form-control'+(this.invalidx?'  is-invalid': '')"
            :disabled="this.$props.disabled" 
            :placeholder="labelx"
            :type="typex"  
            :name="namex" 
            :id="this.idx"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-on:input="modelValue = $event.target.value"

            :required="required"
            :ktype="ktypex"
            style = "min-height: 150px;"
            >
            </textarea>
            <label :for="name">{{this.labelx}}</label>
 	  </div>
      `,
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
    }

}