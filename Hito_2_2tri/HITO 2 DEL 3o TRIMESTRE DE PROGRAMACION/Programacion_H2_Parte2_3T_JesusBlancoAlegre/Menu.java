import java.util.Scanner;

//Menu principal
class Menu {
    Scanner scanner = new Scanner(System.in);
    VerPeliculas verPeliculas = new VerPeliculas();
    AnadirPelicula anadirPelicula = new AnadirPelicula();
    EliminarPelicula eliminarPelicula = new EliminarPelicula();
    ModificarPelicula modificarPelicula = new ModificarPelicula();

    //Opciones del menu
    public void menu() {
        int opcion;
        //Bucle para que se cierre solo al pulsar 5 salir
        do {
            System.out.println("--- Menu Películas ---");
            System.out.println("1 - Ver películas");
            System.out.println("2 - Añadir película");
            System.out.println("3 - Eliminar película");
            System.out.println("4 - Modificar película");
            System.out.println("5 - Salir");

            System.out.print("Seleccione una opción: ");
            opcion = scanner.nextInt();
            scanner.nextLine();
            
            switch (opcion) {
                case 1:
                    verPeliculas.ver();
                    break;
                case 2:
                    anadirPelicula.anadir();
                    break;
                case 3:
                    eliminarPelicula.eliminar();
                    break;
                case 4:
                    modificarPelicula.modificar();
                    break;
                case 5:
                    System.out.println("Saliendo");
                    break;
                default:
                    System.out.println("Opcion incorrecta");
            }
        } while (opcion != 5);
    }
}
