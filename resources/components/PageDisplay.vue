<template>
  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title text-primary">{{ page.title }}</h2>
        <hr />
        <p class="card-text">{{ page.content }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { fetchPageBySlug } from '../services/api'

export default {
  name: 'PageDisplay',
  setup() {
    const route = useRoute()
    const page = ref({})

    const loadPage = async () => {
      try {
        const slug = route.params.slug
        page.value = await fetchPageBySlug(slug)
      } catch (error) {
        console.error('Error fetching page:', error)
      }
    }

    onMounted(loadPage)

    return { page }
  },
}
</script>

<style scoped>
.card {
  max-width: 800px;
  margin: auto;
  border-radius: 10px;
}

.card-title {
  font-weight: bold;
}

.card-text {
  font-size: 1.1rem;
}
</style>
