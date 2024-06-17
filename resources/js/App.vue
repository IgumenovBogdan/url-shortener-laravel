<template>
    <div class="custom-form-container">
        <div v-if="!results.original_url && !results.short_url" class="custom-form-wrapper">
            <h1 class="custom-form-title">URL Shortener</h1>
            <ul class="custom-error-list" v-if="typeof errors === 'object'">
                <li v-for="(value, index) in errors" :key="index">{{ value[0] }}</li>
            </ul>
            <p class="custom-error-message" v-if="typeof errors === 'string'">{{ errors }}</p>
            <form method="post" @submit.prevent="handleSend">
                <div class="custom-form-group">
                    <label class="custom-label" for="url">Please enter your URL</label>
                    <input class="custom-input" id="url" type="text" v-model="form.url" autofocus required />
                </div>
                <div class="custom-form-group">
                    <button class="custom-submit-button action-button" type="submit">Send</button>
                </div>
            </form>
        </div>
        <div v-if="results.original_url && results.short_url" class="custom-form-wrapper">
            <h2 class="copy-status success">
                {{ copyStatus }}
            </h2>
            <h1 class="custom-form-title">Results</h1>
            <h2 class="custom-label">
                Old url:
                <span class="custom-link" @click="handleCopyToClipboard(results.original_url)">
                    {{ results.original_url }}
                </span>
            </h2>
            <h2 class="custom-label">
                Short url:
                <span class="custom-link" @click="handleCopyToClipboard(results.short_url)">
                    {{ results.short_url }}
                </span>
            </h2>
            <div class="custom-form-group">
                <button class="custom-submit-button cancel-button" type="submit" @click="handleClearResults">Try again</button>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, reactive} from "vue";
import { apiService } from './apiService.js';

export default {
    setup() {
        const errors = ref();
        const copyStatus = ref();
        const form = ref({
            url: "",
        });

        const results = reactive({
            original_url: '',
            short_url: ''
        });

        const handleSend = async () => {
            try {
                const response = await apiService.createLink(form.value);
                results.original_url = response.original_url;
                results.short_url = response.short_url;
            } catch (err) {
                errors.value = err.message;
            }
        };

        const handleClearResults = () => {
            form.value.url = '';
            results.original_url = "";
            results.short_url = "";
            errors.value = null;
            copyStatus.value = null;
        };

        const handleCopyToClipboard = async (textToCopy) => {
            await navigator.clipboard.writeText(textToCopy);
            copyStatus.value = 'Copied!';

            setTimeout(() => {
                copyStatus.value = '';
            }, 3000);
        };

        return {
            form,
            errors,
            handleSend,
            results,
            handleClearResults,
            copyStatus,
            handleCopyToClipboard
        };
    }
};
</script>

<style scoped>
.custom-form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.custom-form-wrapper {
    position: relative;
    width: 400px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 8px;
}

.custom-form-title {
    color: #333333;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.custom-error-list {
    color: #ff0000;
    list-style-type: disc;
    margin-left: 20px;
}

.custom-error-message {
    color: #ff0000;
    margin-top: 10px;
}

.custom-form-group {
    margin-bottom: 20px;
}

.custom-label {
    color: #555555;
    font-size: 14px;
    margin-bottom: 5px;
}

.copy-status {
    right: 0;
    padding: 5px;
    position: absolute;
    font-size: 14px;
}

.success {
    color: #51BC83FF;
}

.custom-link {
    overflow-wrap: break-word;
    color: #518ABCFF;
    cursor: pointer;
}

.custom-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #cccccc;
    border-radius: 4px;
    font-size: 16px;
}

.custom-submit-button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.action-button {
    background-color: #3490dc;
    color: #ffffff;
}
.action-button:hover {
    background-color: #2779bd;
}

.cancel-button {
    background-color: #8f8c8c;
    color: #ffffff;
}
.cancel-button:hover {
    background-color: #555555;
}
</style>
