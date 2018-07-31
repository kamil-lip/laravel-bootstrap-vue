<template>
    <div>
        <b-form-input :autocomplete="autocomplete" v-validate="validationRules" :state="errors.has(name) ? false : null"
                      :name="name" :id="name" :type="type" v-model="localValue"></b-form-input>
        <div class="invalid-feedback" v-show="errors.has(name)">{{ errors.first(name) }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'text'
            },
            value: {
                default: null
            },
            name: String,
            autocomplete: {
                type: String,
                default: null
            },
            validationRules: {
                type: String,
                default: "required"
            },
            readonly: {
                type: Boolean,
                default: null
            }
        },
        data() {
            return {
                localValue: this.value
            }
        },
        watch: {
            value(val) {
                this.localValue = val;
            },
            localValue(val) {
                this.$emit("input", val);
            }
        }
    }
</script>