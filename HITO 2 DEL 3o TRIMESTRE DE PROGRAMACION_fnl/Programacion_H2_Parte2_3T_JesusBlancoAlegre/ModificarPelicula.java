import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.Scanner;

//Clase para modificar peliculas en la base de datos
public class ModificarPelicula {
	// Configuración de la conexión
    Scanner scanner = new Scanner(System.in);
    String url = "jdbc:mysql://localhost:3306/cine_JesusBlanco";
    String usuario = "root";
    String contraseña = "1234";

//Metodo que permite modificar varios campos de una pelicula existente
    public void modificar() {
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            System.out.print("Ingrese el ID de la película a modificar: ");
            int id = scanner.nextInt();
            scanner.nextLine();

            //Scanners para insertar los nuevos datos
            System.out.print("Nuevo título: ");
            String nuevoTitulo = scanner.nextLine();

            System.out.print("Nueva duración (en minutos): ");
            int nuevaDuracion = scanner.nextInt();
            scanner.nextLine();

            System.out.print("Nuevo género: ");
            String nuevoGenero = scanner.nextLine();

            System.out.print("¿Disponible en Netflix? (true/false): ");
            boolean nuevoDisponible = scanner.nextBoolean();

            //Actualizar los campos
            String consulta = "UPDATE Peliculas SET titulo = ?, duracion = ?, genero = ?, disponibleenNetflix = ? WHERE idpelicula = ?";
            try (PreparedStatement ps = conexion.prepareStatement(consulta)) {
                ps.setString(1, nuevoTitulo);
                ps.setInt(2, nuevaDuracion);
                ps.setString(3, nuevoGenero);
                ps.setBoolean(4, nuevoDisponible);
                ps.setInt(5, id);

                int filasActualizadas = ps.executeUpdate();
                if (filasActualizadas > 0) {
                    System.out.println("Película modificada correctamente.");
                } else {
                    System.out.println("No existe una película con ese ID.");
                }
            }
        } catch (SQLException e) {
            System.out.println("Error al modificar la película: " + e.getMessage());
        }
    }
}
