package com.inventory.cis;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

import java.util.Calendar;


public class homeActivity extends Activity implements OnClickListener {
	TextView txt_title;
	Button btn_add_inventory, btn_view_inventory, btn_logout;
	SessionManager session;
	Typeface set_font;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.home);

		Calendar c = Calendar.getInstance();
		setContent();
		clickeEvent();
		SetFont();
	}
	
	

	@Override
	public void onBackPressed() {
		moveTaskToBack(true);
//		finish();
	};

	private void setContent() {
		session = new SessionManager(getApplicationContext());
		txt_title = (TextView) findViewById(R.id.txt_title);
		btn_add_inventory = (Button) findViewById(R.id.btn_add_inventory);
		btn_view_inventory = (Button) findViewById(R.id.btn_view_inventory);

		btn_logout = (Button) findViewById(R.id.btn_logout);
	}

	private void clickeEvent() {
		btn_add_inventory.setOnClickListener(this);
		btn_view_inventory.setOnClickListener(this);
		btn_logout.setOnClickListener(this);
	}

	private void SetFont() {
		set_font = Typeface.createFromAsset(
				getApplicationContext().getAssets(), "fonts/AGENCYR.TTF");
		txt_title.setTypeface(set_font);

	}

	@Override
	public void onClick(View v) {

		switch (v.getId()) {

			case R.id.btn_logout:
				AlertDialog.Builder builder = new AlertDialog.Builder(this);
				builder.setTitle("Logout")
						.setMessage("Are you sure you want to log out?")
						.setIcon(android.R.drawable.ic_dialog_alert)
						.setPositiveButton("Yes",
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
														int which) {
										// Yes button clicked, do something
										session.logoutUser();
										finish();
									}
								}).setNegativeButton("No", null) // Do nothing on no
						.show();

				break;

			case R.id.btn_view_inventory:

				Intent i = new Intent(this, ViewInventoryActicity.class);
				startActivity(i);
				break;
			case R.id.btn_add_inventory:

				Intent ii = new Intent(this, AddInventoryActivity.class);
				startActivity(ii);
				break;
		}

	}
}
