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
            namex: '',
            idx: '',
            ktypex: null,
            nowx: false,
        }
    },
    props: [
        'label',
        'name',
        'id',
        'value',
        'type',
        'disabled',
        'ktype',
        'class',
        'invalid',
        'required',
        'now',
    ],
    template: `
      <div class="form-floating mb-3 ">
			<input 
            k
            :class="'form-control'+(this.invalidx?'  is-invalid': '')"
            :disabled="this.$props.disabled" 
            :placeholder="label"
            :type="typex"  
            :name="namex" 
            :id="this.idx"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-on:input="modelValue = $event.target.value"
            :required="required"
            :ktype="ktypex"
            >
            <label :for="name">{{this.label}}</label>
 	  </div>
      `,
    mounted() {
        if (this.$props.type == 'datetime-local')
            this.modelValue = this.$props.type == 'datetime-local' && this.$props.now ? new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 1000 * 60)).toISOString().replace(/(.+):.*/, '$1') : (this.$props.value || '');
        else
            if (this.$props.type == 'date')
                this.modelValue = this.$props.type == 'date' && this.$props.now ? new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 1000 * 60)).toISOString().replace(/(.+?)T.*/, '$1') : (this.$props.value || '')
        this.namex = this.$props.name || prefix + count;
        this.idx = this.$props.idx || this.namex;
        this.typex = this.$props.type == 'text' ? 'search' : this.$props.type;
        this.invalidx = this.$props.required ? true : false;
        this.ktypex = this.$props.ktype ?? null;
    },
    methods: {
        update() {
            this.$emit('update');
        }
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