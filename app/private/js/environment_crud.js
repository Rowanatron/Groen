function error_environment_name() {
    var testable = document.getElementById("test_environment_name");
    if (!testable.checkValidity()) {
        document.getElementById("error_environment_name").innerHTML = "De omgevingsnaam moet minimaal 3 karakters bevatten";
    } else {
        document.getElementById("error_environment_name").innerHTML = "";
    }
}

function add_input(div_name, extra_fields) {

    var new_div = document.createElement('div');
    new_div.innerHTML = "      <div id=\"dynamic_input\">\n" +
        "                        <div class=\"form_block\">\n" +
        "                            <label for=\"vm_name_from\">Machine 1</label><br>\n" +
        "                            <select name=\"vm_name_from[]\" id=\"vm_name_from\" required>\n" +
        "                                <option value=\"\" disabled selected hidden>Kies een machine</option>\n" +
        "                                <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>\n" +
        "                                    <option value=\"<?= $vm->getName(); ?>\"><?= $vm->getName(); ?></option>\n" +
        "                                <?php endforeach; ?>\n" +
        "                            </select>\n" +
        "                        </div>\n" +
        "\n" +
        "                        <div class=\"form_block\">\n" +
        "                            <label for=\"bidirectional\">Relatie</label><br>\n" +
        "                            <select name=\"bidirectional[]\" id=\"bidirectional\" required>\n" +
        "                                <option value=\"\" disabled selected hidden>Relatie</option>\n" +
        "                                <option value=\"0\">enkelvoudig</option>\n" +
        "                                <option value=\"1\">tweevoudig</option>\n" +
        "                            </select>\n" +
        "                        </div>\n" +
        "\n" +
        "                        <div class=\"form_block\">\n" +
        "                            <label for=\"vm_name_to\">Machine 2</label><br>\n" +
        "                            <select name=\"vm_name_to[]\" id=\"vm_name_to\" required>\n" +
        "                                <option value=\"\" disabled selected hidden>Kies een machine</option>\n" +
        "                                <?php foreach (get_sorted_virtualmachine_list() as $vm) : ?>\n" +
        "                                    <option value=\"<?= $vm->getName(); ?>\"><?= $vm->getName(); ?></option>\n" +
        "                                <?php endforeach; ?>\n" +
        "                            </select>\n" +
        "                        </div>\n" +
        "\n" +
        "                        <div class=\"form_block form_full_length\">\n" +
        "                            <label> Omschrijving<br>\n" +
        "                                <textarea id=\"test_description\" rows = \"5\" cols = \"50\" name = \"relation_description[]\" onkeydown=\"setTimeout(error_description, 1500)\"></textarea>\n" +
        "<!--                                <input id=\"test_description\" name=\"relation_description[]\" type=\"text\" maxlength=\"255\"-->\n" +
        "<!--                                       onkeydown=\"setTimeout(error_description, 1500)\" value=\" \"/>-->\n" +
        "                                <p id=\"error_description\" class=\"error_message\"></p>\n" +
        "                            </label>\n" +
        "                        </div>\n" +
        "                    </div> <!-- end dynamic input --><input id='del-relationship-btn' type='button' value='Verwijder deze relatie' onclick='this.parentNode.parentNode.removeChild(this.parentNode);'/>";

    document.getElementById(extra_fields).appendChild(new_div);
}