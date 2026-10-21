document.addEventListener('DOMContentLoaded', () => {
    const $ = (id) => document.getElementById(id);

    // Dynamic Services Data (loaded from backend JSON)
    let S = [];
    const servicesDataEl = $('servicesData');
    if (servicesDataEl) {
        try {
            S = JSON.parse(servicesDataEl.textContent || '[]');
        } catch (e) {
            console.error('Failed to parse servicesData JSON:', e);
        }
    }

    const m = $('m');
    let cur = 0;

    const ic = (s) => {
        const icon = (s.i || '').trim();
        if (!icon) {
            return '<svg class="i size-[26px]" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/></svg>';
        }
        if (icon.startsWith('data:image') || icon.startsWith('http://') || icon.startsWith('https://')) {
            return `<img src="${icon}" alt="${s.t || 'Icon'}" class="size-[26px] object-contain">`;
        }
        if (icon.startsWith('ri-') || icon.startsWith('fa-')) {
            return `<i class="${icon} text-[26px]"></i>`;
        }
        if (icon.startsWith('<svg')) {
            return icon;
        }
        return `<svg class="i size-[26px]" viewBox="0 0 24 24">${icon}</svg>`;
    };

    // If modal elements exist, wire them up
    if (m) {
        document.addEventListener('click', (e) => {
            const c = e.target.closest('[data-n]');
            if (!c) return;
            cur = Number(c.dataset.n);
            const s = S[cur];
            if (!s) return;

            if ($('mi')) $('mi').innerHTML = ic(s);
            if ($('mt')) $('mt').textContent = s.t || '';
            if ($('md')) $('md').textContent = s.l || s.d || '';

            const mbHeading = $('mbh');
            const mbList = $('mb');
            if (mbList) {
                if (Array.isArray(s.b) && s.b.length > 0) {
                    if (mbHeading) mbHeading.classList.remove('hidden');
                    mbList.classList.remove('hidden');
                    mbList.innerHTML = s.b
                        .map((x) => `<li class="flex gap-3 text-[15px] text-mu"><span class="mt-2 size-1.5 shrink-0 rounded-full bg-ac"></span>${x}</li>`)
                        .join('');
                } else {
                    if (mbHeading) mbHeading.classList.add('hidden');
                    mbList.classList.add('hidden');
                    mbList.innerHTML = '';
                }
            }
            document.documentElement.style.overflow = 'hidden';
            if (typeof m.showModal === 'function') {
                m.showModal();
            } else {
                m.setAttribute('open', '');
            }
        });

        m.addEventListener('click', (e) => {
            if (e.target === m) m.close();
        });

        ['x', 'x2'].forEach((id) => {
            const btn = $(id);
            if (btn) btn.onclick = () => m.close();
        });

        m.addEventListener('close', () => {
            document.documentElement.style.overflow = '';
        });

        const mc = $('mc');
        if (mc) {
            mc.onclick = () => {
                const fs = $('fs');
                if (fs && S[cur]) {
                    fs.value = S[cur].t;
                }
                m.close();
            };
        }
    }

    // Mobile Navbar Toggle
    const nb = $('nb');
    const np = $('np');
    const nm = $('nm');
    const bt = $('bt');

    if (nb && np && nm) {
        const nav = (isOpen) => {
            np.classList.toggle('hidden', !isOpen);
            nb.setAttribute('aria-expanded', String(isOpen));
            nm.setAttribute('d', isOpen ? 'M6 6l12 12M18 6L6 18' : 'M4 7h16M4 12h16M4 17h16');
        };

        nb.onclick = () => nav(np.classList.contains('hidden'));
        np.addEventListener('click', (e) => {
            if (e.target.closest('a')) nav(false);
        });

        window.matchMedia('(min-width:1024px)').addEventListener('change', (e) => {
            if (e.matches) nav(false);
        });
    }

    // Back to top button visibility
    if (bt) {
        const sc = () => {
            const on = window.scrollY > 500;
            bt.classList.toggle('opacity-0', !on);
            bt.classList.toggle('pointer-events-none', !on);
            bt.classList.toggle('translate-y-3', !on);
        };
        window.addEventListener('scroll', sc, { passive: true });
        sc();
    }

    // Student Registration Modal Controls
    const regModal = $('registerModal');
    const openRegBtn = $('openRegisterBtn');
    const openRegBtnMobile = $('openRegisterBtnMobile');
    const closeRegBtn = $('closeRegisterBtn');
    const closeRegSuccessBtn = $('closeRegSuccessBtn');
    const regForm = $('studentRegistrationForm');
    const regFormContainer = $('regFormContainer');
    const regSuccessState = $('regSuccessState');

    if (regModal) {
        const openRegistration = () => {
            document.documentElement.style.overflow = 'hidden';
            if (typeof regModal.showModal === 'function') {
                regModal.showModal();
            } else {
                regModal.setAttribute('open', '');
            }
        };

        const closeRegistration = () => {
            document.documentElement.style.overflow = '';
            if (typeof regModal.close === 'function') {
                regModal.close();
            } else {
                regModal.removeAttribute('open');
            }
        };

        if (openRegBtn) {
            openRegBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openRegistration();
            });
        }

        if (openRegBtnMobile) {
            openRegBtnMobile.addEventListener('click', (e) => {
                e.preventDefault();
                if (np && !np.classList.contains('hidden')) {
                    np.classList.add('hidden');
                    if (nm) nm.setAttribute('d', 'M4 7h16M4 12h16M4 17h16');
                    if (nb) nb.setAttribute('aria-expanded', 'false');
                }
                openRegistration();
            });
        }

        if (closeRegBtn) {
            closeRegBtn.addEventListener('click', closeRegistration);
        }

        // Reset registration form & state
        const resetRegistrationForm = () => {
            if (regForm) regForm.reset();
            if (regFormContainer) regFormContainer.classList.remove('hidden');
            if (regSuccessState) regSuccessState.classList.add('hidden');
            const alertBox = $('regGlobalAlert');
            if (alertBox) alertBox.classList.add('hidden');
            if (regForm) {
                regForm.querySelectorAll('.field-error').forEach((el) => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });
                regForm.querySelectorAll('input, select').forEach((el) => {
                    el.classList.remove('!border-rose-500', '!focus:border-rose-500');
                });
            }
        };

        if (closeRegSuccessBtn) {
            closeRegSuccessBtn.addEventListener('click', () => {
                closeRegistration();
                setTimeout(resetRegistrationForm, 300);
            });
        }

        const registerAnotherBtn = $('registerAnotherBtn');
        if (registerAnotherBtn) {
            registerAnotherBtn.addEventListener('click', () => {
                resetRegistrationForm();
                const firstInput = regForm?.querySelector('select, input');
                if (firstInput) firstInput.focus();
            });
        }

        regModal.addEventListener('click', (e) => {
            if (e.target === regModal) closeRegistration();
        });

        regModal.addEventListener('close', () => {
            document.documentElement.style.overflow = '';
        });

        // Real asynchronous registration form submission
        if (regForm) {
            regForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Clear previous errors
                const globalAlert = $('regGlobalAlert');
                const globalAlertMsg = $('regGlobalAlertMsg');
                if (globalAlert) globalAlert.classList.add('hidden');

                regForm.querySelectorAll('.field-error').forEach((el) => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });
                regForm.querySelectorAll('input, select').forEach((el) => {
                    el.classList.remove('!border-rose-500');
                });

                const submitBtn = $('submitRegBtn');
                if (!submitBtn) return;

                const originalContent = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="size-5 animate-spin text-[#04130D]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Submitting Application...</span>
                `;

                try {
                    const formData = new FormData(regForm);
                    const actionUrl = regForm.getAttribute('action') || '/online-registration';

                    const response = await fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    const data = await response.json().catch(() => null);

                    if (response.ok && data && (data.status === 'success' || data.success)) {
                        const successMsgEl = $('regSuccessMessage');
                        if (successMsgEl && data.message) {
                            successMsgEl.textContent = data.message;
                        }

                        if (regFormContainer) regFormContainer.classList.add('hidden');
                        if (regSuccessState) regSuccessState.classList.remove('hidden');
                    } else if (response.status === 422 && data && data.errors) {
                        let firstErrorField = null;
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const errorEl = regForm.querySelector(`[data-error-field="${field}"]`);
                            const inputEl = regForm.querySelector(`[name="${field}"]`);

                            if (errorEl && messages.length > 0) {
                                errorEl.textContent = messages[0];
                                errorEl.classList.remove('hidden');
                            }
                            if (inputEl) {
                                inputEl.classList.add('!border-rose-500');
                                if (!firstErrorField) firstErrorField = inputEl;
                            }
                        }

                        if (firstErrorField) {
                            firstErrorField.focus();
                        }

                        if (globalAlert && globalAlertMsg) {
                            globalAlertMsg.textContent = data.message || 'Please fix the highlighted fields above.';
                            globalAlert.classList.remove('hidden');
                        }
                    } else {
                        if (globalAlert && globalAlertMsg) {
                            globalAlertMsg.textContent = (data && data.message) || 'Something went wrong. Please check your submission and try again.';
                            globalAlert.classList.remove('hidden');
                        }
                    }
                } catch (error) {
                    console.error('Registration submission error:', error);
                    if (globalAlert && globalAlertMsg) {
                        globalAlertMsg.textContent = 'Connection error. Please check your network and try again.';
                        globalAlert.classList.remove('hidden');
                    }
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            });
        }
    }
});
