<template>
    <div>
        <input
            type="checkbox"
            class="checkbox"
            @change="toggle"
            :checked="checked"
        />
    </div>
</template>

<script>

export default {
    name: "BooleanField",
    props: [
        "disabled",
        "value"
    ],

    methods: {
        toggle(e) {
            this.$emit("input", !!e.target.checked);
        }
    },

    computed: {
        checked() {
            return Boolean(this.value)
        },
    },
}
</script>
