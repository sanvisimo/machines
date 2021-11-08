<template>
        <div class="accordion">
            <div class="accordion__header">
                <div class="accordion__link p-4 block flex justify-center cursor-pointer" @click.prevent="active = !active">
                    <div class="bg-blue-dark hover:bg-blue-darker no-underline border p-2">
                        <strong>{{ __('tutte le informazioni') }}</strong>
                    </div>
                </div>
            </div>
            <div class="accordion__content py-3 card px-6" v-show="active">
                <div class="grid grid-cols-2 gap-4">
                    <component
                        v-for="(field, index) in panel.fields"
                        :key="'accordion-' + index"
                        class="col-span-1"
                        :style="{width: 'auto'}"
                        :is="componentName(field)"
                        :resource-name="resourceName"
                        :resource-id="resourceId"
                        :resource="resource"
                        :field="field"
                        @actionExecuted="actionExecuted"
                    />
                </div>
            </div>
        </div>

</template>

<script>
import BehavesAsPanel from 'laravel-nova/src/mixins/BehavesAsPanel'

export default {
    mixins: [BehavesAsPanel],
    data() {
        return {
            active: false,
        };
    },
    mounted() {
        document.getElementsByClassName('accordion')[0].classList.remove('flex-dom')
        document.getElementsByClassName('accordion')[0].classList.remove('flex-wrap')
        document.getElementsByClassName('accordion')[0].classList.remove('flex')
    },
    methods: {
        /**
         * Handle the actionExecuted event and pass it up the chain.
         */
        actionExecuted() {
            this.$emit("actionExecuted");
        },

        handleTabClick(tab, event) {
            tab.init = true
            this.activeTab = tab.name
        },

        componentName(field) {
            return field.prefixComponent ? 'detail-' + field.component : field.component
        }
    }
}
</script>
