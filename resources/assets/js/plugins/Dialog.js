import YesNoDialog from '../components/common/YesNoDialog';

export default {

    install(Vue) {
        if (this.installed) {
            return
        }

        this.installed = true;

        Vue.component('yes-no-dialog', YesNoDialog);

        Vue.prototype.$confirm = (question) => {

            if (this.yesNoDialog) {

                return new Promise((resolve) => {
                    this.yesNoDialog.confirm(question);
                    this.yesNoDialog.$on('answer', (result) => {
                        resolve(result);
                    });
                });

            }

        }
    }
}
