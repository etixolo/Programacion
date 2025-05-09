import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLIntegrityConstraintViolationException;
import java.sql.SQLException;
import java.util.Scanner;

//Clase para añadir nuevas peliculas a la base de datos
public class AnadirPelicula {
    // Configuracion de la conexion
    Scanner scanner = new Scanner(System.in);
    String url = "jdbc:mysql://localhost:3306/cine_JesusBlanco";
    String usuario = "root";
    String contraseña = "1234";


    //Metodo que solicita los datos de una nueva pelicula y la añade a la base de datos.

    public void anadir() {
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            // Solicitar datos al usuario
            System.out.print("ID de la película: ");
            int id = scanner.nextInt();
            scanner.nextLine();

            System.out.print("Título de la película: ");
            String titulo = scanner.nextLine();

            System.out.print("Duración de la película (minutos): ");
            int duracion = scanner.nextInt();
            scanner.nextLine();

            System.out.print("Género de la película: ");
            String genero = scanner.nextLine();

            System.out.print("¿Disponible en Netflix? (true/false): ");
            boolean disponible = scanner.nextBoolean();

            System.out.print("Presupuesto de la película: ");
            int presupuesto = scanner.nextInt();

            // Insert en costes
            String consultaCoste = "INSERT INTO Costes (idpelicula, presupuesto) VALUES (?, ?)";
            try (PreparedStatement psCoste = conexion.prepareStatement(consultaCoste)) {
                psCoste.setInt(1, id);
                psCoste.setInt(2, presupuesto);
                psCoste.executeUpdate();
            }

            // Insert en peliculas
            String consultaPelicula = "INSERT INTO Peliculas (idpelicula, titulo, duracion, genero, disponibleenNetflix) VALUES (?, ?, ?, ?, ?)";
            try (PreparedStatement psPelicula = conexion.prepareStatement(consultaPelicula)) {
                psPelicula.setInt(1, id);
                psPelicula.setString(2, titulo);
                psPelicula.setInt(3, duracion);
                psPelicula.setString(4, genero);
                psPelicula.setBoolean(5, disponible);
                psPelicula.executeUpdate();
            }

            System.out.println("Película añadida correctamente.");

        } catch (SQLIntegrityConstraintViolationException e) {
            System.out.println("Error: Ya existe una película con ese ID.");
        } catch (SQLException e) {
            System.out.println("Error al añadir película: " + e.getMessage());
        }
    }
}
