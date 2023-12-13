document.addEventListener("DOMContentLoaded", function() {
  const steps = document.querySelectorAll(".step");
  let currentStep = 0;

  function showStep(stepIndex) {
      steps.forEach(step => step.style.display = "none");
      steps[stepIndex].style.display = "block";
  }

  const btnEmail = document.getElementById("btn-email");

  btnEmail.addEventListener("click", function() {
      currentStep = 1;
      showStep(currentStep);
  });

  showStep(currentStep);
});
