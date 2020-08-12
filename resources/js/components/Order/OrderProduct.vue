<template>
  <article class="OrderProduct">
    <h5 class="OrderProduct__name">{{ product.name }}</h5>
    <div class="OrderProduct__details">
      <span class="OrderProduct__quantity pr-1">{{ $t('quantity') }}: {{ product.quantity }}</span>
      <span class="OrderProduct__weight">{{ $t('weight') }}: {{ product.weight }} kg</span>
      <button class="OrderProduct__remove" type="button" @click="removeProduct">
        <fa icon="trash" fixed-width />
      </button>
    </div>
  </article>
</template>

<script>

export default {
  name: 'OrderProduct',
  props: {
    product: {
      type: Object,
      default: null
    }
  },
  methods: {
    removeProduct() {
      this.$emit('removeProduct', this.product.uuid)
    }
  }
}
</script>

<style lang="scss">
@import './../../../sass/_variables.scss';

.OrderProduct {
  display: block;
  padding: 1.5rem 4rem 1.5rem 1.5rem;
  border: 1px solid $gray-300;
  position: relative;
  border-radius: $border-radius;
  overflow: hidden;
  margin-top: 1rem;
  line-height: 1;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

  &:hover {
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    border-color: $input-focus-border-color;
  }

  &__name {
    font-size: .85rem;
    font-weight: 600;
    margin-bottom: .25rem;
    line-height: 1;
    color: $gray-800;
  }

  &__details {
    font-size: .65rem;
    font-weight: 600;
    color: $gray-600;
  }

  &__remove {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 3rem;
    background: #eee;
    border: none;
    padding: 0;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 1rem;

    &:active,
    &:focus,
    &:hover {
      outline: none;
    }
  }

}

</style>