import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

// Clase para mostar los datos de las tablas
public class VerPeliculas {
	// Configuración de la conexión
    String url = "jdbc:mysql://localhost:3306/cine_JesusBlanco";
    String usuario = "root";
    String contraseña = "1234";

    //Metodo que muestra todas las peliculas
    public void ver() {
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            String consulta = "SELECT Peliculas.idpelicula, titulo, duracion, genero, disponibleenNetflix, presupuesto " +
                               "FROM Peliculas INNER JOIN Costes ON Peliculas.idpelicula = Costes.idpelicula";

            Statement stmt = conexion.createStatement();
            ResultSet rs = stmt.executeQuery(consulta);

            System.out.printf("%-5s %-20s %-10s %-15s %-10s %-12s\n",
                    "ID", "Título", "Duración", "Género", "Netflix", "Presupuesto");

            while (rs.next()) {
                System.out.printf("%-5d %-20s %-10d %-15s %-10b %-12d\n",
                        rs.getInt("idpelicula"),
                        rs.getString("titulo"),
                        rs.getInt("duracion"),
                        rs.getString("genero"),
                        rs.getBoolean("disponibleenNetflix"),
                        rs.getInt("presupuesto"));
            }
            rs.close();
            stmt.close();
        } catch (SQLException e) {
            System.out.println("Error al mostrar películas: " + e.getMessage());
        }
    }
}
