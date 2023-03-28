 /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
 function openNav() {
    document.getElementById("sidebar").style.width = "250px";
    document.getElementById("main_content").style.marginLeft = "250px";
    // document.getElementById("header").style.width= "87%";
    document.getElementById("openbtn").style.display = "none";
  }

  /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    document.getElementById("main_content").style.marginLeft = "0";
    //document.getElementById("header").style.width= "100%";
    document.getElementById("openbtn").style.display = "block";

  }

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      document.getElementById("sidebar").style.width = "250px";
      document.getElementById("main_content").style.marginLeft = "250px";
    } else {
      document.getElementById("sidebar").style.width = "0";
      document.getElementById("main_content").style.marginLeft = "0";
    }
  });