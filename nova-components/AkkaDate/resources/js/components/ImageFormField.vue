<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
        <div class="cursor-pointer" @click="onOpenModal">
            <img :src="field.thumbnailUrl" :alt="field.value" />
        </div>
        <portal to="modals" transition="fade-transition">
            <modal
                v-if="openModal"
                @modal-close="closeModal"

            >
                <div
                    class="bg-40 rounded-lg shadow-lg overflow-hidden p-8 relative"
                    style="width: 50vw; margin-top: 50%; transform: translateY(-50%)"
                >
                    <div class="absolute cursor-pointer" style="right: 8px; top: 8px;"  @click="closeModal">
                        <font-awesome-icon icon="fa-regular fa-times-circle" class="w-6 h-6" />
                    </div>
                    <img :src="field.previewUrl" :alt="field.value" />
                </div>
            </modal>
        </portal>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import DetailField from "./DetailField";

export default {
    components: {DetailField},
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],
    name: "ImageFormField",
    data(){
        return {
            openModal: false
        }
    },
    methods: {
        onOpenModal() {
            this.openModal = true;
        },
        closeModal() {
            this.openModal = false;
        }
    }
}
</script>

<style scoped>

</style>
