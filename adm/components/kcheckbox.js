let count = 0;
const prefix = 'kc-';
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
            indeterminatex: false,
            checkedx: false,
        }
    },
    props: [
        'label',
        'name',
        'id',
        'value',
        'disabled',
        'ktype',
        'class',
        'invalid',
        'required',
        'now',
        'indeterminate',
        'checked',
    ],
    template: `
      <div class="form-check mb-3 ">
			<input 
            k
            :checked="checkedx"
            :indeterminate="indeterminatex"
            :class="'form-check-input'+(this.invalidx?'  is-invalid': '')"
            :disabled="this.$props.disabled" 
            :placeholder="label"
            type="checkbox"  
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
        // this.checked = this.$props.checked;
        this.namex = this.$props.name || prefix + count;
        this.idx = this.$props.idx || this.namex;
        this.indeterminatex = this.$props.indeterminate ? true : false;
        //this.invalidx = this.$props.required ? true : false;
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
            this.checkedx = newVal == 1 ? true : false;
        }

    }

}