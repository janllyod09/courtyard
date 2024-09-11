<div class="w-full">
    <style>
        .scrollbar-thin1::-webkit-scrollbar {
                       width: 5px;
                   }

       .scrollbar-thin1::-webkit-scrollbar-thumb {
           background-color: #1a1a1a4b;
           /* cursor: grab; */
           border-radius: 0 50px 50px 0;
       }

       .scrollbar-thin1::-webkit-scrollbar-track {
           background-color: #ffffff23;
           border-radius: 0 50px 50px 0;
       }

       @media (max-width: 1024px){
           .custom-d{
               display: block;
           }
       }

       @media (max-width: 768px){
           .m-scrollable{
               width: 100%;
               overflow-x: scroll;
           }
       }

       @media (min-width:1024px){
           .custom-p{
               padding-bottom: 14px !important;
           }
       }

       @-webkit-keyframes spinner-border {
           to {
               transform: rotate(360deg);
           }
       }

       @keyframes spinner-border {
           to {
               transform: rotate(360deg);
           }
       }

       .spinner-border {
           display: inline-block;
           width: 1rem;
           height: 1rem;
           vertical-align: text-bottom;
           border: 2px solid currentColor;
           border-right-color: transparent;
           border-radius: 50%;
           -webkit-animation: spinner-border .75s linear infinite;
           animation: spinner-border .75s linear infinite;
           color: rgb(0, 255, 42);
       }
   </style>

    <div class="flex justify-center w-full">
        <div class="w-full bg-white rounded-2xl p3 sm:p-8 shadow dark:bg-gray-800 overflow-x-visible">
            <div class="pb-4 mb-3">
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white">
                    Payroll Payment Slip
                </h1>
            </div>

            <div class="block sm:flex items-center pb-2 justify-between">

                <div class="block sm:flex items-center">


                </div>

            </div>

            <!-- Table -->
            <div class="flex flex-col p-3">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block w-full py-2 align-middle">
                        <div class="overflow-hidden border dark:border-gray-700 rounded-lg">
                            <div class="overflow-x-auto">

                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
