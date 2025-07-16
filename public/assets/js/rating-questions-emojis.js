 // Add interactive feedback for each rating option
        document.querySelectorAll('.rating-option').forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                const emoji = this.querySelector('.emoji');
                const radioName = radio.name;
                
                // Remove selection from all options with the same name (same question)
                document.querySelectorAll(`input[name="${radioName}"]`).forEach(sameNameRadio => {
                    sameNameRadio.closest('.rating-option').classList.remove('selected');
                });
                
                // Add selection to current option
                this.classList.add('selected');
                
                // Add animation
                emoji.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    emoji.style.transform = 'scale(1)';
                }, 200);
            });
        });