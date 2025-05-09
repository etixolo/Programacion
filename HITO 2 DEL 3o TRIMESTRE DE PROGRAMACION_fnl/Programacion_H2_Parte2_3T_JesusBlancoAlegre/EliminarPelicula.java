import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.Scanner;


//Clase para eliminar peliculas

public class EliminarPelicula {
    // Configuración de la conexión
    Scanner scanner = new Scanner(System.in);
    String url = "jdbc:mysql://localhost:3306/cine_JesusBlanco";
    String usuario = "root";
    String contraseña = "1234";

    //Metodo que elimina la pelicula segun ID

    public void eliminar() {
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            System.out.print("Ingrese el ID de la película a eliminar: ");
            int id = scanner.nextInt();

            //Delete de peliculas
            String consultaPelicula = "DELETE FROM Peliculas WHERE idpelicula = ?";
            try (PreparedStatement psPelicula = conexion.prepareStatement(consultaPelicula)) {
                psPelicula.setInt(1, id);
                int filasPeliculas = psPelicula.executeUpdate();

                if (filasPeliculas > 0) {
                	//Delete de costes
                    String consultaCoste = "DELETE FROM Costes WHERE idpelicula = ?";
                    try (PreparedStatement psCoste = conexion.prepareStatement(consultaCoste)) {
                        psCoste.setInt(1, id);
                        psCoste.executeUpdate();
                    }
                    System.out.println("Película eliminada correctamente.");
                } else {
                    System.out.println("No existe una película con ese ID.");
                }
            }
        } catch (SQLException e) {
            System.out.println("Error al eliminar película: " + e.getMessage());
        }
    }
}
