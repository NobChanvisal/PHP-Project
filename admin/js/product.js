
      console.log("hello")
        function openModal() {
            console.log("open");
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

       
        const sortButton = document.getElementById('sortButton');
        const sortDropdown = document.getElementById('sortDropdown');
        sortButton.addEventListener('click', () => {
            sortDropdown.classList.toggle('hidden');
        });

        
        document.addEventListener('click', (event) => {
            if (!sortButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                sortDropdown.classList.add('hidden');
            }
        });
        const modelBtn = document.getElementById('btn-model');
        modelBtn.addEventListener('click', () => {
          console.log("oeeee")
        })
