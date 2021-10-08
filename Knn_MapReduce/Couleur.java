package principal;

public class Couleur {
	private int r;
	private int v;
	private int b;
	private String nom;				// Nom css de la couleur
	private int etiquette;			// Exemple : chaude, froide ou neutre
	private double distance;
	
	
	public Couleur(int r, int v, int b, String nom, int etiquette) {
		this.r = r;
		this.v = v;
		this.b = b;
		this.nom = nom;
		this.etiquette = etiquette;
	}
	public Couleur(String ligne) {
		//System.out.println( ">>" + ligne);
		String[] valeurs = ligne.split(";");
		this.r = Integer.valueOf( valeurs[1] );
		this.v = Integer.valueOf( valeurs[2] );
		this.b = Integer.valueOf( valeurs[3] );
		this.nom = valeurs[0];
		this.etiquette = Integer.valueOf(valeurs[5]);		
	}
	
	public int getR() {
		return r;
	}
	public void setR(int r) {
		this.r = r;
	}
	public int getV() {
		return v;
	}
	public void setV(int v) {
		this.v = v;
	}
	public int getB() {
		return b;
	}
	public void setB(int b) {
		this.b = b;
	}
	public String getNom() {
		return nom;
	}
	public void setNom(String nom) {
		this.nom = nom;
	}
	public int getEtiquette() {
		return etiquette;
	}
	public void setEtiquette(int etiquette) {
		this.etiquette = etiquette;
	}	
	public double getDistance() {
		return distance;
	}
	public void setDistance(double distance) {
		this.distance = distance;
	}
	
}
