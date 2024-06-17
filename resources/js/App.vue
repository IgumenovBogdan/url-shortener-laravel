<template>
    <div class="custom-form-container">
        <h1>Hello world</h1>
    </div>
</template>

<script>

export default {
    setup() {

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

.custom-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #cccccc;
    border-radius: 4px;
    font-size: 16px;
}

.custom-submit-button {
    background-color: #3490dc;
    color: #ffffff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-submit-button:hover {
    background-color: #2779bd;
}
</style>
