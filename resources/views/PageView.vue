<template>
  <div class="container mt-4">
    <!-- Loading Spinner -->
    <div v-if="loading" class="text-center mt-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <!-- Error Message -->
    <div v-else-if="error" class="alert alert-danger text-center">
      <strong>Error:</strong> {{ error }}
    </div>

    <!-- Page Content -->
    <div v-else class="card shadow-sm mx-auto page-container">
      <div class="card-body">
        <h1 class="card-title text-primary text-center">{{ page?.title }}</h1>
        <hr />
        <p class="card-text" v-html="page?.content"></p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { fetchPageBySlug } from '../services/api'

export default {
  setup() {
    const route = useRoute()
    const page = ref(null)
    const loading = ref(true)
    const error = ref(null)

    const loadPage = async () => {
      loading.value = true
      error.value = null
      try {
        const slugPath = route.params.slug
        page.value = await fetchPageBySlug(slugPath)
      } catch (err) {
        error.value = 'Page not found!'
      }
      loading.value = false
    }

    watch(() => route.params.slug, loadPage, { immediate: true })

    return { page, loading, error }
  },
}
</script>

<style scoped>
.page-container {
  max-width: 800px;
  margin-top: 20px;
  padding: 20px;
  border-radius: 10px;
  background-color: #fff;
}

.card-title {
  font-weight: bold;
}

.card-text {
  font-size: 1.1rem;
  text-align: justify;
}

.alert {
  max-width: 600px;
  margin: 20px auto;
}
</style>
