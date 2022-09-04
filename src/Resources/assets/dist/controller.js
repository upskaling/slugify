import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['lock', 'slug_input'];

    connect() {
        this.slug_inputTarget.readOnly = !this.slug_inputTarget.readOnly;
        this.slug_inputTarget.addEventListener('input', (e) => this.updateSlug(e));

        if (this.slug_inputTarget.value.length <= 0) {
            const slugTypeTargetFieldTarget = document.getElementById(this.slug_inputTarget.dataset.slugTypeTargetFieldTarget);
            slugTypeTargetFieldTarget?.addEventListener('input', (e) => this.updateSlug(e));
        }
    }

    updateSlug(e) {
        this.slug_inputTarget.value = e.target.value.toLowerCase().replace(/ /g, '-');
    }

    lock() {
        this.lockTarget.classList.toggle('fa-lock');
        this.lockTarget.classList.toggle('fa-lock-open');

        this.slug_inputTarget.readOnly = !this.slug_inputTarget.readOnly;
    }
}
